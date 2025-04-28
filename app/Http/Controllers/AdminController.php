<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function deletePost(Post $post)
    {
        $post->delete();

        return back()->with('success', 'Post supprimé avec succès.');
    }

    public function deleteUser(User $user)
    {
        // Supprime aussi les posts de l'utilisateur si tu veux :
        $user->posts()->delete();

        // Ensuite supprime l'utilisateur
        $user->delete();

        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }
}
