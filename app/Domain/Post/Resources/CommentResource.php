<?php

namespace App\Domain\Post\Resources;

use App\Domain\User\Resources\UserResource;
use App\Models\Comment;
use App\Models\CommentReaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * @property-read Comment resource;
 */

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user_Id = Auth::id();
        return [
            'id' => $this->resource->id,
            'comment' => $this->resource->comment,
            'created_at' => $this->resource->created_at,
            'current_user_has_reaction_comment' => $this->resource->hasReactionFromUser($user_Id),
            'num_of_reaction_comments' => $this->resource->countReactions(),
            'updated_at' => $this->resource->updated_at,
            'num_of_sub_comments' => $this->resource->countSubComments(),
            'sub_comments' => CommentResource::collection($this->resource->latest3SubComments()->get()),
            'user' => [
                "id" => $this->user->id,
                "name" => $this->user->name,
                "avatar_url" => $this->user->avatar_path,
                "username" => $this->user->username
            ]
        ];
    }
}
