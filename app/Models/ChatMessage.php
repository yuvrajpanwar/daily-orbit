<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    public $timestamps = false;   // we use sent_at + created_at manually

    protected $fillable = ['session_id', 'role', 'content', 'tokens_est', 'sent_at'];

    protected $casts = ['sent_at' => 'datetime'];

    public function session(): BelongsTo
    {
        return $this->belongsTo(ChatSession::class, 'session_id');
    }
}