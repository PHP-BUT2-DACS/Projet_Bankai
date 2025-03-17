<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        Follow::create([
            'follower_id' => auth()->id(),
            'followed_id' => $user->id,
        ]);
        return back()->with('success', 'Abonnement réussi !');
    }

    public function unfollow(User $user)
    {
        Follow::where('follower_username', auth()->id())
            ->where('followed_username', $user->id)
            ->delete();
        return back()->with('success', 'Désabonnement réussi !');
    }

    public function followers(User $user)
    {
        $followers = $user->followers;
        return view('users.followers', compact('followers'));
    }

    public function followings(User $user)
    {
        $followings = $user->followings;
        return view('users.followings', compact('followings'));
    }
}
