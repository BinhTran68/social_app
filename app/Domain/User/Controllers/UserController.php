<?php

namespace App\Domain\User\Controllers;


use App\Domain\User\Actions\SearchUserAction;
use App\Domain\User\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function find(Request $request)
    {
        $userId = Auth::id();
        $searchAction = new SearchUserAction();
        $query = $searchAction->searchByKeyword($request->get('keyword'));
        $perPage = $request->get('page');
        if (!$perPage) {
            $users = $query->get()->whereNotIn('id', [$userId]);
        } else {
            $users = $query->whereNotIn('id', [$userId])->paginate($perPage);
        }
        $users = UserResource::collection($users);
        return response($users, 200);
    }
}
