<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use Carbon\Carbon;

class ChatController extends Controller
{
    public function index()
    {
        return view('admin.chats.index');
    }

    public function fetch()
    {
        $query = ChatSession::query()
            ->withCount('messages')
            ->orderBy('last_active_at', 'DESC');

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('visitor', function ($row) {
                $meta = $row->meta ?? [];
                return !empty($meta['visitor_name']) ? ucfirst($meta['visitor_name']) : '<span class="text-muted">Unknown</span>';
            })
            ->addColumn('first_message', function ($row) {
                // First user message (skip the greeting which is assistant role)
                $msg = ChatMessage::where('session_id', $row->id)
                    ->where('role', 'user')
                    ->orderBy('sent_at', 'asc')
                    ->first();
                return $msg ? \Str::limit(strip_tags($msg->content), 60) : '<span class="text-muted">—</span>';
            })
            ->addColumn('last_message', function ($row) {
                $msg = ChatMessage::where('session_id', $row->id)
                    ->orderBy('sent_at', 'desc')
                    ->first();
                return $msg ? \Str::limit(strip_tags($msg->content), 60) : '<span class="text-muted">—</span>';
            })
            ->addColumn('messages_count', function ($row) {
                return $row->messages_count;
            })
            ->addColumn('started_at', function ($row) {
                return Carbon::parse($row->started_at)->format('d/m/y h:i A');
            })
            ->addColumn('last_active_at', function ($row) {
                return Carbon::parse($row->last_active_at)->format('d/m/y h:i A');
            })
            ->addColumn('status', function ($row) {
                $isActive = $row->ended_at === null
                    && Carbon::parse($row->last_active_at)->gt(now()->subMinutes(30));

                return $isActive
                    ? '<span class="badge badge-success">Active</span>'
                    : '<span class="badge badge-secondary">Ended</span>';
            })
            ->addColumn('actions', function ($row) {
                return '<button class="btn btn-sm btn-primary view-chat-btn" data-id="' . $row->id . '">
                            <i class="fe fe-eye"></i> View
                        </button>';
            })
            ->rawColumns(['visitor', 'first_message', 'last_message', 'status', 'actions'])
            ->make(true);
    }

    public function messages($id)
    {
        $session  = ChatSession::findOrFail($id);
        $messages = ChatMessage::where('session_id', $id)
            ->orderBy('sent_at', 'asc')
            ->get()
            ->map(fn($m) => [
                'role'    => $m->role,
                'content' => $m->content,
                'sent_at' => Carbon::parse($m->sent_at)->format('d/m/y h:i A'),
            ]);

        $meta = $session->meta ?? [];

        return response()->json([
            'visitor_name' => $meta['visitor_name'] ?? 'Unknown Visitor',
            'started_at'   => Carbon::parse($session->started_at)->format('d M Y, h:i A'),
            'messages'     => $messages,
        ]);
    }
}