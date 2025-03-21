<?php

namespace App\Http\Controllers;

use App\Models\Get;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BlogController extends Controller
{
    public function index() {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('posts.index', ['posts' => $posts]);
    }

    public function create(){
        return view('posts.create');
    }

    public function store(Request $request) {
        // Validations
        $request->validate([
            'title' => 'required',
            'text' => 'required', // 'text' correspond au contenu du blog
        ]);

        $post = new Post;

        // Assignation des valeurs aux champs de la base de données
        $post->user_username = auth()->user()->getAuthIdentifierName(); // Récupère le nom d'utilisateur de l'utilisateur connecté
        $post->title = $request->title;
        $post->text = $request->text; // 'text' est le contenu du blog
        $post->post_date = now(); // Utilise la date et l'heure actuelles pour 'post_date'
        $post->created_at = now(); // Définit la date de création
        $post->updated_at = now(); // Définit la date de mise à jour

        // Sauvegarde du post dans la base de données
        $post->save();

        // Redirection avec un message de succès
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

}
