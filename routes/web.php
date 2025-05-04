<?php

use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TrainingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

Route::get('/matches', [App\Http\Controllers\SportsMatchController::class, 'index'])->name('matches.index');

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
Route::post('/teams/{team}/leave', [TeamController::class, 'leave'])->name('teams.leave');
Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');

Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');

Route::get('/search', [SearchController::class, 'search'])->name('search');


Route::middleware('auth')->group(function () {
    Route::get('/calendar', function () {
        return view('calendar');
    })->name('calendar');

    Route::resource('conferences', ConferenceController::class);
    Route::post('conferences/{conference}/join', [ConferenceController::class, 'joinConference'])->name('conferences.join');

    Route::resource('trainings', TrainingController::class);
});


// Groupe protégé par middleware admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::delete('/posts/{post}', [AdminController::class, 'deletePost'])->name('admin.posts.delete');
    Route::delete('/user/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/dashboard', function () { return view('admin.dashboard');})->name('admin.dashboard');
});



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
