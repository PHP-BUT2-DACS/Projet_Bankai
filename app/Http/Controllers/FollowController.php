<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        auth()->user()->followings()->attach($user->id);
        return back()->with('success', 'Follow réussi !');
    }

    public function unfollow(User $user)
    {
        auth()->user()->followings()->detach($user->id);
        return back()->with('success', 'Unfollow réussi !');
    }
}
