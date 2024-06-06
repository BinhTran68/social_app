<?php

namespace App\Domain\Group\Actions;

use App\Domain\Group\Enums\GroupUserRole;
use App\Domain\Group\Enums\GroupUserStatus;
use App\Domain\Group\Requests\StoreGroupRequest;
use App\Domain\Group\Resources\GroupResource;
use App\Models\Group;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Auth;

class StoreGroupAction
{
    public function handle(StoreGroupRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $group = Group::create($data);

        $groupUserData = [
            'status' => GroupUserStatus::APPROVED->value,
            'role' => GroupUserRole::ADMIN->value,
            'user_id' => Auth::id(),
            'group_id' => $group->id,
            'created_by' => Auth::id()
        ];

        GroupUser::create($groupUserData);

        return response(new GroupResource($group), 201);
    }
}
