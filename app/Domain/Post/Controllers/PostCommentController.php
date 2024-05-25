<?php

namespace App\Domain\Post\Controllers;

use App\Domain\Post\Actions\CreateCommentAction;
use App\Domain\Post\Requests\CommentRequest;
use App\Domain\Post\Resources\CommentResource;
use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostCommentController
{
    public function index(Request $request,Post $post)
    {
        $page = $request->query('page', 1);
        $comments = $post->comments()->latest()->paginate(5, ['*'], 'page', $page);
        return CommentResource::collection($comments);

    }

    public function store(CommentRequest $request, Post $post)
    {
        $createCommentAction  = new CreateCommentAction();
        return  $createCommentAction->handle($request, $post);
    }
}
