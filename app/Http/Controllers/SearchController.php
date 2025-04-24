<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Sport;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $key = trim($request->get('q'));

        $posts = Post::query()
            ->where('title', 'like', "%$key%")
            ->orWhere('content', 'like', "%$key%")
            ->orderBy('created_at', 'desc')
            ->get();

        $users = User::query()
            ->where('username', 'like', "%$key%")
            ->orderBy('created_at', 'desc')
            ->get();

        $sports = Sport::query()
            ->where('name', 'like', "%$key%")
            ->orderBy('created_at', 'desc')
            ->get();

        $recent_posts = Post::query()
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('search', [
            'key' => $key,
            'posts' => $posts,
            'users' => $users,
            'sports' => $sports,
            'recent_posts' => $recent_posts,
        ]);
    }
}
