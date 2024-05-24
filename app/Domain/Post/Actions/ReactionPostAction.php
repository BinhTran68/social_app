<?php

namespace App\Domain\Post\Actions;

use App\Domain\Post\Enum\PostReactionEnum;
use App\Models\Post;
use App\Models\PostReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReactionPostAction
{
    public function handle(Request $request, Post $post)
    {
        $data = $request->validate([
           'reaction' => Rule::enum(PostReactionEnum::class)
        ]);
        $user_id = Auth::id();

        $reaction = PostReaction::query()->where('user_id', $user_id)->where('post_id', $post->id)->first();
        if ($reaction) {
            $hasReaction=false;
            $reaction ->delete();
        }else {
            $hasReaction=true;
            PostReaction::create([
                'post_id' => $post->id,
                'user_id' => $user_id,
                'type' => $data['reaction']
            ]);

        }
        $reactions = PostReaction::where('post_id', $post->id)->count();
        return response([
           'num_of_reactions' => $reactions,
           'current_user_has_reaction' => $hasReaction
        ]);

    }

}
