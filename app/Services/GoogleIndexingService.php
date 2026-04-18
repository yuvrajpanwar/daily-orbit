<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * GoogleIndexingService
 *
 * Pings Google (and Bing) to notify them when a post is published/updated/deleted.
 * Uses Google's Indexing API and Bing's IndexNow protocol.
 *
 * SETUP REQUIRED:
 *  1. Go to Google Search Console → Settings → Ownership verification → HTML tag
 *  2. Go to Google Cloud Console → Create a Service Account → Download JSON key
 *  3. Add the service account email in Search Console → Settings → Users and permissions
 *  4. Place the JSON key file at: storage/app/google-indexing-credentials.json
 *  5. Set BING_INDEXNOW_KEY in your .env file
 */
class GoogleIndexingService
{
    private string $indexingApiUrl = 'https://indexing.googleapis.com/v3/urlNotifications:publish';
    private ?string $accessToken   = null;

    /**
     * Notify Google that a URL was UPDATED (published/edited)
     */
    public function notifyUpdated(string $url): bool
    {
        return $this->notify($url, 'URL_UPDATED');
    }

    /**
     * Notify Google that a URL was DELETED (unpublished/deleted)
     */
    public function notifyDeleted(string $url): bool
    {
        return $this->notify($url, 'URL_DELETED');
    }

    /**
     * Notify multiple URLs at once (batch — use after bulk publish)
     */
    public function notifyBatch(array $urls, string $type = 'URL_UPDATED'): array
    {
        $results = [];
        foreach ($urls as $url) {
            $results[$url] = $this->notify($url, $type);
            // Small delay to avoid rate limits (200 calls/day limit)
            usleep(100000); // 0.1 second
        }
        return $results;
    }

    /**
     * Ping Bing/IndexNow — simpler, no auth needed, just an API key
     * Works for Bing, Yandex, and other IndexNow-compatible search engines
     */
    public function pingIndexNow(string $url): bool
    {
        $key = config('services.indexnow.key');

        if (empty($key)) {
            Log::warning('IndexNow: BING_INDEXNOW_KEY not set in .env');
            return false;
        }

        try {
            $response = Http::timeout(10)->post('https://api.indexnow.org/indexnow', [
                'host'    => parse_url(config('app.url'), PHP_URL_HOST),
                'key'     => $key,
                'urlList' => [$url],
            ]);

            if ($response->successful() || $response->status() === 202) {
                Log::info("IndexNow: Pinged successfully → {$url}");
                return true;
            }

            Log::warning("IndexNow: Failed [{$response->status()}] → {$url}");
            return false;

        } catch (\Exception $e) {
            Log::error("IndexNow: Exception → {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Core notify method — calls Google Indexing API
     */
    private function notify(string $url, string $type): bool
    {
        $token = $this->getAccessToken();
        if (!$token) {
            Log::warning("GoogleIndexing: No access token — skipping ping for {$url}");
            return false;
        }

        try {
            $response = Http::withToken($token)
                ->timeout(15)
                ->post($this->indexingApiUrl, [
                    'url'  => $url,
                    'type' => $type,
                ]);

            if ($response->successful()) {
                Log::info("GoogleIndexing: [{$type}] → {$url}");
                return true;
            }

            Log::warning("GoogleIndexing: Failed [{$response->status()}] → {$url} — " . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error("GoogleIndexing: Exception → {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Get OAuth2 access token from Google service account JSON key
     */
    private function getAccessToken(): ?string
    {
        if ($this->accessToken) {
            return $this->accessToken;
        }

        $credentialsPath = storage_path('app/google-indexing-credentials.json');

        if (!file_exists($credentialsPath)) {
            Log::warning('GoogleIndexing: Credentials file not found at ' . $credentialsPath);
            return null;
        }

        try {
            $credentials = json_decode(file_get_contents($credentialsPath), true);

            $now = time();
            $jwt = $this->buildJwt($credentials, $now);

            $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion'  => $jwt,
            ]);

            if ($response->successful()) {
                $this->accessToken = $response->json('access_token');
                return $this->accessToken;
            }

            Log::error('GoogleIndexing: Token fetch failed — ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('GoogleIndexing: Token exception — ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Build a signed JWT for Google OAuth2
     */
    private function buildJwt(array $credentials, int $now): string
    {
        $header  = base64_encode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
        $payload = base64_encode(json_encode([
            'iss'   => $credentials['client_email'],
            'sub'   => $credentials['client_email'],
            'scope' => 'https://www.googleapis.com/auth/indexing',
            'aud'   => 'https://oauth2.googleapis.com/token',
            'iat'   => $now,
            'exp'   => $now + 3600,
        ]));

        $signingInput = "{$header}.{$payload}";
        $privateKey   = openssl_pkey_get_private($credentials['private_key']);

        openssl_sign($signingInput, $signature, $privateKey, 'SHA256');

        return $signingInput . '.' . base64_encode($signature);
    }
}