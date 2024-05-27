<?php

namespace App\Domain\Post\Actions;

use App\Domain\Post\Enum\ReactionEnum;
use App\Models\Comment;
use App\Models\CommentReaction;
use App\Models\PostReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CommentReactionAction
{
    public function handle(Request $request,Comment $comment)
    {
        $data = $request->validate([
            'reaction' => Rule::enum(ReactionEnum::class)
        ]);
        $user_id = Auth::id();

        $reaction = CommentReaction::query()
            ->where('user_id', $user_id)
            ->where('comment_id', $comment->id)->first();
        if ($reaction) {
            $hasReactionComment=false;
            $reaction ->delete();
        }else {
            $hasReactionComment=true;
            CommentReaction::create([
                'comment_id' => $comment->id,
                'user_id' => $user_id,
                'type' => $data['reaction']
            ]);
        }
        $reactions = CommentReaction::where('comment_id', $comment->id)->count();
        return response([
            'num_of_reaction_comments' => $reactions,
            'current_user_has_reaction_comments' => $hasReactionComment
        ]);



    }
}
