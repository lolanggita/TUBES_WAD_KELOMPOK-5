<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class CommentController extends Controller
{
    public function store(Request $request, Event $event)
    {
        try {
            $validated = $request->validate([
                'content' => 'required|string|min:1|max:500',
            ]);

            $comment = $event->comments()->create([
                'user_id' => Auth::id(),
                'content' => $validated['content'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil ditambahkan.',
                'data' => $comment->load('user'),
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function update(Request $request, Comment $comment)
    {
        try {
            $this->authorize('update', $comment);

            $validated = $request->validate([
                'content' => 'required|string|min:1|max:500',
            ]);

            $comment->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil diperbarui.',
                'data' => $comment->load('user'),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Anda tidak diizinkan mengedit komentar ini.',
            ], 403);
        }
    }

    public function destroy(Comment $comment)
    {
        try {
            $this->authorize('delete', $comment);

            $comment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil dihapus.',
            ]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Anda tidak diizinkan menghapus komentar ini.',
            ], 403);
        }
    }
}