<?php

namespace App\Domain\Post\Controllers;

use App\Domain\Post\Actions\CreateCommentAction;
use App\Domain\Post\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostCommentController
{
    public function store(CommentRequest $request, Post $post)
    {
        $createCommentAction  = new CreateCommentAction();
        return  $createCommentAction->handle($request, $post);
    }
}
