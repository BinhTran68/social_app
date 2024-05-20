<?php

namespace App\Domain\Post\Actions;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class DeletePostAction
{
    public function handle(Post $post)
    {
        try {
            $id = Auth::id();
            if ($post->user_id != $id) {
                return response("You don't have permission delete this post", 403);
            }
            $post->delete();
            return back();
        }catch (\Exception $exception) {
            throw  $exception;
        }

    }
}
