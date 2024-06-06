<?php

namespace App\Domain\Friendships\Controllers;

use App\Domain\User\Resources\UserResource;
use App\Models\User;
use Inertia\Inertia;

class FriendshipController
{
    public function index()
    {
        return Inertia::render( 'client/Friendship/FriendMainPage', [

        ]);
    }

    public function suggestFriendship(User $user)
    {
        // Get user do not yet friendship  by ..
         $users = User::query()->paginate(12);
         $users = UserResource::collection($users);
         return response($users, 200);
    }
}
