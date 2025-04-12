<?php

use App\Http\Controllers\APIMatchController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

// Route pour afficher les posts du blog
Route::get('/posts', [BlogController::class, 'index'])->name('posts.index');

// Route pour la page d'accueil (affiche les matchs)
Route::get('/', [APIMatchController::class, 'index'])->name('matches.index');

// Route pour le tableau de bord, avec middleware d'authentification et vérification
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Groupement des routes nécessitant l'authentification
Route::middleware('auth')->group(function () {
    // Routes pour la gestion du profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route pour récupérer les matchs depuis l'API externe
Route::get('/', [APIMatchController::class, 'index'])->name('matches.index');

// Inclusion des routes d'authentification générées par Laravel Breeze ou Jetstream
require __DIR__.'/auth.php';
