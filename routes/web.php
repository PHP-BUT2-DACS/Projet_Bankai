<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('/', BlogController::class)->names([
    'index' => 'posts.index',
    'create' => 'posts.create',
    'store' => 'posts.store',
    'show' => 'posts.show',
]);

Route::get('/users/{user}/followers', [FollowController::class, 'followers'])->name('followers');

Route::get('/users/{user}/followings', [FollowController::class, 'followings'])->name('followings');

Route::post('/users/{user}/follow', [FollowController::class, 'follow'])->name('follow');
Route::post('/users/{user}/unfollow', [FollowController::class, 'unfollow'])->name('unfollow');
Route::get('/users/{user}/followers', [FollowController::class, 'followers'])->name('followers');
Route::get('/users/{user}/followings', [FollowController::class, 'followings'])->name('followings');

require __DIR__.'/auth.php';
