<?php

namespace App\Domain\Home\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()->paginate(20);
        return Inertia::render('client/Home/Home', [
            'posts' => $posts
        ]);
    }
}
