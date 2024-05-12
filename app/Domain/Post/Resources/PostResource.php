<?php

namespace App\Domain\Post\Resources;

use App\Domain\User\Resources\UserResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'id' => $this->resource->getKey(),
            'body' => $this->resource->body,
            'updated_at' => $this->resource->updated_at,
            'created_at' => $this->resource->created_at,
            'user' =>   new UserResource($this->resource->user),
            'group' => $this->resource->group(),
            'attachments' =>  $this->resource->attachments()
        ];
    }
}
