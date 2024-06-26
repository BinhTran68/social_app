<?php

use App\Domain\Friendships\Controllers\FriendshipController;
use App\Domain\Group\Controllers\GroupController;
use App\Domain\Group\Controllers\GroupViewController;
use App\Domain\Home\Controllers\HomeController;
use App\Domain\Post\Controllers\PostCommentController;
use App\Domain\Post\Controllers\PostController;
use App\Domain\Post\Controllers\PostReactionController;
use App\Domain\User\Controllers\ProfileController;
use App\Domain\User\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::get('/shows', [HomeController::class, 'shows'])
    ->middleware(['auth', 'verified'])
    ->name('home.shows');


Route::get('/u/{user:username}', [ProfileController::class, 'index'])
    ->name('profile');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update-images', [ProfileController::class, 'updateImages'])
        ->name('profile.update-cover');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // User
    Route::get('/users/find', [UserController::class, 'find'])->name('user.find_keyword');

    // Friends
     Route::get('/friends', [FriendshipController::class, 'index'])->name('friend.index');
     Route::get('/friends/{user}', [FriendshipController::class, 'suggestFriendship'])->name('friend.suggest');
//     Route::get('/friends/friend-requests', [FriendshipController::class, 'index'])->name('friend.index');
//     Route::get('/friends/suggestions', [FriendshipController::class, 'index'])->name('friend.index');
//     Route::get('/friends/all-friends', [FriendshipController::class, 'index'])->name('friend.index');



    Route::post('/posts', [PostController::class, 'store'])->name('post.create');
    // Cannot use put, patch
    Route::post('/posts/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('post.destroy');

    // Reaction Post
    Route::post('/posts/{post}/reaction', [PostReactionController::class, 'store'])
        ->name('post.reaction');
    // Post Comments
    Route::post('/posts/{post}/comments', [PostCommentController::class, 'store'])
        ->name('post.comment');
    Route::get('/posts/{post}/comments', [PostCommentController::class, 'index'])
        ->name('post.view_more_comment');
    Route::put('/posts/{comment}/comments', [PostCommentController::class, 'update'])
        ->name('post.comment-edit');
    Route::delete('/posts/{comment}/comments', [PostCommentController::class, 'destroy'])
        ->name('post.comment.destroy');

    // Reaction comment
    Route::put('/posts/comments/{comment}/reaction', [PostCommentController::class, 'reaction'])
        ->name('post.comment.reaction');

    // Groups
    Route::get('/group/{group:slug}', [GroupController::class, 'show'])
        ->name('group.show');
    Route::get('/groups', [GroupController::class, 'index'])
        ->name('group.index');
    Route::post('/groups', [GroupController::class, 'store'])
        ->name('group.create');

    Route::post('/groups/{group}/image', [GroupViewController::class, 'updateImages'])
        ->name('group.update_image');


});

require __DIR__.'/auth.php';
