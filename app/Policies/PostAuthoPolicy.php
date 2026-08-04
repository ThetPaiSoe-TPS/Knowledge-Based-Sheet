<?php

namespace App\Policies;

use App\Models\PostAutho;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class PostAuthoPolicy
{
    // ✅ Anyone can view posts
    public function viewAny(User $user): bool
    {
        return true;
    }

    // ✅ Anyone can view a single post
    public function view(User $user, PostAutho $post): bool
    {
        return true;
    }

    // ✅ Only admin or editor can create
    public function create(User $user): bool
    {
        // ✅ Debug: log the user role
        Log::info('Policy create() called', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'is_admin' => $user->isAdmin(),
            'is_editor' => $user->isEditor()
        ]);

        // ✅ Return true for admin or editor
        return $user->isAdmin() || $user->isEditor();
    }

    // ✅ Only owner or admin can update
    public function update(User $user, PostAutho $post): bool
    {
        return $user->id === $post->user_id || $user->isAdmin();
    }

    // ✅ Only owner or admin can delete
    public function delete(User $user, PostAutho $post): bool
    {
        return $user->id === $post->user_id || $user->isAdmin();
    }

    // ✅ Only admin can publish
    public function publish(User $user, PostAutho $post): bool
    {
        return $user->isAdmin();
    }
}
