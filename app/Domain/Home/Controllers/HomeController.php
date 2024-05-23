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
        $userId = Auth::id();

        $posts = Post::query()
                ->withCount('reactions')
                ->latest()
                ->paginate(20);
        return Inertia::render('client/Home/Home', [
            'posts' => PostResource::collection($posts)
        ]);
    }
}
