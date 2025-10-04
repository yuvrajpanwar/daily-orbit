<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\VerifyEmail;

class EmailVerificationController extends Controller
{
    public function sendLink(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return response()->json(['success' => false, 'message' => 'Email already verified.']);
        }

        // Generate signed URL valid for 60 mins
        $verifyUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        // Send email
        Mail::to($user->email)->send(new VerifyEmail($user, $verifyUrl));

        return response()->json(['success' => true, 'message' => 'Verification link sent successfully!']);
    }

    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals(sha1($user->email), $hash)) {
            abort(403, 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('account.index')->with('success', 'Email already verified.');
        }

        $user->markEmailAsVerified();

        return redirect()->route('account.index')->with('success', 'Email verified successfully!');
    }
}
