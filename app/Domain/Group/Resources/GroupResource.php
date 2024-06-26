<?php

namespace App\Domain\Group\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this ->id,
            "name"=> $this ->name,
            "slug"=> $this ->slug,
            "cover_path"=> Storage::url($this->cover_path),
            "thumbnail_path"=> Storage::url($this->thumbnail_path),
            "auto_approval"=> $this ->auto_approval,
            "about"=> $this ->about,
            "user_id"=> $this ->user_id,
            "deleted_at"=> $this ->deleted_at,
            "deleted_by"=> $this ->deleted_by,
            "created_at"=> $this ->created_at,
            "updated_at"=> $this ->updated_at,
        ];
    }
}
