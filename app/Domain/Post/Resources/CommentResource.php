<?php

namespace App\Domain\Post\Resources;

use App\Domain\User\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id' => $this->id,
          'comment' => $this->comment,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
          'user' => [
              "id" => $this->user->id,
              "name" => $this->user->name,
              "avatar_url" => $this->user->avatar_path
          ]
        ];
    }
}
