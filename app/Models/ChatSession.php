<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatSession extends Model
{
    use HasUuids;

    protected $fillable = [
        'session_key', 'started_at', 'last_active_at',
        'ended_at', 'ip_address', 'user_agent', 'meta',
    ];

    protected $casts = [
        'meta'           => 'array',
        'started_at'     => 'datetime',
        'last_active_at' => 'datetime',
        'ended_at'       => 'datetime',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'session_id')->orderBy('sent_at');
    }
}