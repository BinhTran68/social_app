<?php

use App\Domain\Home\Controllers\HomeController;
use App\Domain\Post\Controllers\PostController;
use App\Domain\Post\Controllers\PostReactionController;
use App\Domain\User\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home');

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

    Route::post('/posts', [PostController::class, 'store'])->name('post.create');
    // Cannot use put, patch
    Route::post('/posts/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('post.destroy');

    // Reaction Post
    Route::post('/posts/{post}/reaction', [PostReactionController::class, 'store'])
        ->name('post.reaction');

});

require __DIR__.'/auth.php';
