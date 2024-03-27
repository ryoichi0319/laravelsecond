<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
class PostPolicy
{
    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return bool
     */
    public function view(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can edit the post.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return bool
     */
    public function edit(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
}
