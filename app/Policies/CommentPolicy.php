<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    // Semua role bisa membuat komentar
    public function create(User $user)
    {
        return true; // Semua user login bisa buat komentar
    }

    // User bisa melihat komentar jika mereka adalah pemilik atau admin/ukm
    public function view(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id || $user->isAdmin() || $user->isUkm();
    }

    // Hanya pemilik komentar atau admin yang bisa edit
    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id || $user->isAdmin();
    }

    // Pemilik komentar atau admin bisa hapus
    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id || $user->isAdmin();
    }
}
