<?php

namespace App\Domain\Group\Controllers;

use App\Domain\Group\Actions\StoreGroupAction;
use App\Domain\Group\Enum\GroupUserStatus;
use App\Domain\Group\Requests\StoreGroupRequest;
use App\Domain\Group\Requests\UpdateGroupRequest;
use App\Domain\Group\Resources\GroupResource;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::query()
            ->select('groups.*','gu.role')
            ->join('group_users as gu', 'gu.group_id', 'groups.id')
            ->where('gu.user_id', Auth::id())
            ->where('status', GroupUserStatus::APPROVED->value)
            ->get();

        return Inertia::render( 'client/Group/GroupPage', [
            'groups' => $groups
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request, StoreGroupAction $storeGroupAction)
    {
        return $storeGroupAction->handle($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        return Inertia::render( 'client/Group/GroupView', [
            'group' => GroupResource::make($group)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }
}
