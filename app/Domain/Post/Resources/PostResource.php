<?php

namespace App\Domain\Post\Resources;

use App\Domain\User\Resources\UserResource;
use App\Models\Post;
use App\Models\PostAttachment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * @property-read Post resource;
 */

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     *
     *
     */
    public function toArray(Request $request): array
    {
        $userId = Auth::id();

        return [
            'id' => $this->resource->getKey(),
            'body' => $this->resource->body,
            'updated_at' => $this->resource->updated_at,
            'created_at' => $this->resource->created_at,
            'user' =>   new UserResource($this->resource->user),
            'group' => $this->resource->group(),
            'attachments' =>  PostAttachmentResource::collection($this->resource->attachments),
            'num_of_reactions' => $this->reactions_count,
            'has_reaction' => $this->resource->hasReactionFromUser($userId)
        ];
    }
}
