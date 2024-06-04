<?php

namespace App\Domain\Group\Actions;

use App\Domain\Group\Requests\UpdateImageGroupProfileRequest;
use App\Domain\Group\Resources\GroupResource;
use App\Models\Group;

class UpdateImageProfileAction
{
    public function handle(UpdateImageGroupProfileRequest $request, Group $group)
    {
        $data = $request->validated();
        $file = $data['file'];
        if ($data['type'] === 'cover') {
            $path = $file->store('cover-img-groups/'.$group->id, 'public');
            $group->cover_path = $path;
        }else {
            $path = $file->store('avatar-img-groups/'.$group->id, 'public');
            $group->thumbnail_path = $path;
        }
        $group->save();
        return response(GroupResource::make($group), 200);
    }
}
