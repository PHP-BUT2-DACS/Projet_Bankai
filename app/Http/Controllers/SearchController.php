<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Team;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $key = trim($request->get('q'));

        if (!empty($key)) {
            // Si on fait une recherche
            $posts = Post::search($key)->get();
            $users = User::search($key)->get();
            $teams = Team::search($key)->get();
            $recent_posts = collect(); // vide
        } else {
            // Si aucune recherche
            $posts = collect(); // vide
            $users = collect(); // vide
            $teams = collect(); // vide

            $recent_posts = Post::where('is_published', true)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }

        return view('search', [
            'key' => $key,
            'posts' => $posts,
            'users' => $users,
            'teams' => $teams,
            'recent_posts' => $recent_posts
        ]);
    }
}
