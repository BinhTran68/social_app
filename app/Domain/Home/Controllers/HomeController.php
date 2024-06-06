<?php

namespace App\Domain\Home\Controllers;

use App\Domain\Group\Enums\GroupUserStatus;
use App\Domain\Group\Resources\GroupResource;
use App\Domain\Post\Resources\PostResource;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()
            ->withCount('reactions')
            ->latest()
            ->paginate(5);

        $posts = PostResource::collection($posts);
        if ($request->wantsJson()) {
            return  $posts;
        }

        $groups = Group::query()
            ->select('groups.*','gu.role')
            ->join('group_users as gu', 'gu.group_id', 'groups.id')
            ->where('gu.user_id', Auth::id())
            ->where('status', GroupUserStatus::APPROVED->value)
            ->get();
        $groups = GroupResource::collection($groups);
        return Inertia::render( 'client/Home/Home', [
            'posts' => $posts,
            'groups' => $groups
        ]);
    }

    public function shows(Request $request)
    {
        $posts = Post::query()
            ->withCount('reactions')
            ->latest()
            ->paginate(5);
        return response($posts, 200);
    }

}
