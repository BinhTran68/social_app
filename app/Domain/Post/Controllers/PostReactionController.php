<?php

namespace App\Domain\Post\Controllers;

use App\Domain\Post\Actions\ReactionPostAction;
use App\Domain\Post\Enums\ReactionEnum;
use App\Models\Post;
use App\Models\PostReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class PostReactionController
{
    public function store(Request $request,Post $post, ReactionPostAction $reactionPostAction)
    {
        return $reactionPostAction->handle($request,$post);
    }

}
