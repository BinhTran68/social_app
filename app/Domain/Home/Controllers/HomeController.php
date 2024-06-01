<?php

namespace App\Domain\Home\Controllers;

use App\Domain\Post\Resources\PostResource;
use App\Http\Controllers\Controller;
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
        return Inertia::render( 'client/Home/Home', [
            'posts' => $posts
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
