<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\MatchTabController;

Route::get('/matches', [MatchTabController::class, 'index'])->name('matches.index');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create')->middleware('auth');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store')->middleware('auth');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy')->middleware('auth');
Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like')->middleware('auth');
Route::post('/posts/{post}/unlike', [PostController::class, 'unlike'])->name('posts.unlike')->middleware('auth');

Route::get('/user/{username}', [UserController::class, 'show'])->name('profile.show');
Route::post('/user/{username}/follow', [UserController::class, 'follow'])->name('profile.follow')->middleware('auth');
Route::post('/user/{username}/unfollow', [UserController::class, 'unfollow'])->name('profile.unfollow')->middleware('auth');
Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::post('/user/profile/update', [UserController::class, 'update'])->name('profile.update')->middleware('auth');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
/*
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});*/

require __DIR__.'/auth.php';
