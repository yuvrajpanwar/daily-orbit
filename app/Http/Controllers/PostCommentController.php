<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostCommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required|string|min:3|max:2000',
        ]);

        $comment = PostComment::create([
            'post_id'    => $post->id,
            'user_id'    => Auth::id(),
            'comment'    => $request->comment,
            'is_approved' => 1, // or false + moderation later
        ]);

        // Load fresh comment with user relation
        $comment->load('user');

        return response()->json([
            'success' => true,
            'comment' => $this->formatComment($comment),
        ]);
    }

    public function loadMore(Request $request, Post $post)
    {
        $perPage = 5;
        $page = $request->query('page', 2); // page 1 is already loaded

        $comments = PostComment::where('post_id', $post->id)
            ->with('user')
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page);

        if ($comments->isEmpty()) {
            return response()->json(['comments' => [], 'has_more' => false]);
        }

        $html = '';
        foreach ($comments as $comment) {
            $html .= $this->renderCommentHtml($comment);
        }

        return response()->json([
            'comments'  => $html,
            'has_more'  => $comments->hasMorePages(),
            'next_page' => $comments->currentPage() + 1,
        ]);
    }

    private function formatComment($comment): array
    {
        return [
            'html' => $this->renderCommentHtml($comment),
        ];
    }

    private function renderCommentHtml($comment): string
    {
        $avatar = $comment->user->avatar
            ?? $comment->user->profile_picture
            ?? 'default-user.png';

        $time = $comment->created_at->format('h:i A d-m-Y');

        return view('components.comment-item', compact('comment', 'avatar', 'time'))->render();
    }
}