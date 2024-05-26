<?php

namespace App\Domain\Post\Controllers;

use App\Domain\Post\Actions\CreateCommentAction;
use App\Domain\Post\Actions\UpdateCommentAction;
use App\Domain\Post\Requests\CommentRequest;
use App\Domain\Post\Requests\UpdateCommentPostRequest;
use App\Domain\Post\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

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

    public function update(UpdateCommentPostRequest $request, Comment $comment, UpdateCommentAction $updateCommentAction)
    {
      return  $updateCommentAction->handle($request,$comment);
    }
}
