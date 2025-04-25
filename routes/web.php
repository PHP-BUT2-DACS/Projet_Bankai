<?php

use App\Http\Controllers\APIMatchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::get('/matches', [APIMatchController::class, 'index'])->name('matches.index');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index')->middleware('auth');
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

Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
Route::post('/teams/{team}/join', [TeamController::class, 'join'])->name('teams.join');
Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');

Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');



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
