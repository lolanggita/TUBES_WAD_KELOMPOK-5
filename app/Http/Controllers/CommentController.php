<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Event;

/**
 * @var \Illuminate\Contracts\Auth\StatefulGuard|\Illuminate\Contracts\Auth\Factory $auth
 */
class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy']);
    }
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $event->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim.');
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate(['content' => 'required']);

        $comment->update($request->only('content'));

        return back()->with('success', 'Komentar berhasil diperbarui.');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}