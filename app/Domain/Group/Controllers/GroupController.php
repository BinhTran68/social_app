<?php

namespace App\Domain\Group\Controllers;

use App\Domain\Group\Actions\StoreGroupAction;
use App\Domain\Group\Requests\StoreGroupRequest;
use App\Domain\Group\Requests\UpdateGroupRequest;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
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
