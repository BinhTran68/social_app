<?php

namespace App\Domain\Post\Actions;

use App\Domain\Post\Requests\UpdateCommentPostRequest;
use App\Domain\Post\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;

class UpdateCommentAction
{
    public function handle(UpdateCommentPostRequest $request, Comment $comment)
    {
        $data =  $request->validated();
        $comment->comment = $data['comment'];
        $comment->save();
        return response(CommentResource::make($comment), 200);
    }
}
