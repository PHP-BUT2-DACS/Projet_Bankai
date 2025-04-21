<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function show(string $username, Request $request): View
    {
        $user = User::query()
            ->where('username', $username)
            ->with(['posts', 'followers', 'following'])
            ->firstOrFail();

        $isFollowing = Auth::check() && Auth::user()->following()->where('followed_id', $user->id)->exists();

        $tab = $request->query('tab', 'posts');

        return view('profile', [
            'user' => $user,
            'tab' => $tab,
            'isFollowing' => $isFollowing,
        ]);
    }

    public function follow(string $username): RedirectResponse
    {
        $userToFollow = User::where('username', $username)->firstOrFail();

        if (Auth::id() === $userToFollow->id) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas vous suivre vous-même.');
        }

        Auth::user()->following()->attach($userToFollow->id);

        return redirect()->route('profile.show', $username)->with('success', 'Vous suivez maintenant ' . $userToFollow->username);
    }

    public function unfollow(string $username): RedirectResponse
    {
        $userToUnfollow = User::where('username', $username)->firstOrFail();

        Auth::user()->following()->detach($userToUnfollow->id);

        return redirect()->route('profile.show', $username)->with('success', 'Vous ne suivez plus ' . $userToUnfollow->username);
    }

    public function edit(): View
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:app_users,username,' . $user->id],
            'email' => ['required', 'email', 'max:100', 'unique:app_users,mail_address,' . $user->id],
            'name' => ['nullable', 'string', 'max:50'],
            'lastname' => ['nullable', 'string', 'max:50'],
            'favorite_sports' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:100'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $user->update($validated);

        return redirect()->route('profile.show', $user->username)->with('success', 'Profil mis à jour avec succès !');
    }
}
