<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Sport;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $key = trim($request->get('q'));

        // Recherche avec Scout
        $posts = Post::search($key)->get();
        $users = User::search($key)->get();
        $sports = Sport::search($key)->get();

        // Posts récents (uniquement si pas de recherche)
        $recent_posts = empty($key)
            ? Post::where('is_published', true)
                  ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
            : collect();

        return view('search', [
            'key' => $key,
            'posts' => $posts,
            'users' => $users,
            'sports' => $sports,
            'recent_posts' => $recent_posts
        ]);
    }
}
