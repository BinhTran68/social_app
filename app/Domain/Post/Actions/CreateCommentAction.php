<?php

namespace App\Domain\Post\Actions;

use App\Domain\Post\Requests\CommentRequest;
use App\Domain\Post\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CreateCommentAction
{
    public function handle(CommentRequest $request, Post $post)
    {
        $data = $request->validated();
        $comment = Comment::create([
            'post_id' => $post->id,
            'comment' => $data['comment'],
            'user_id' => Auth::id()
        ]);
        return response( CommentResource::make($comment), 201);
    }

}
