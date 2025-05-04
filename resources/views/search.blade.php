@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">

        <!-- Champ de recherche -->
        <form method="GET" action="{{ route('search') }}" class="mb-6">
            <input type="text" name="q" value="{{ old('q', $key) }}" class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Recherche...">
        </form>

        <!-- Résultats Utilisateurs -->
        <div class="mb-10">
            <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">👤 Utilisateurs</h2>
            @forelse ($users as $user)
                <div class="flex items-center mb-4 bg-white dark:bg-gray-800 p-4 rounded-lg shadow hover:shadow-lg transition">
                    <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('images/default-avatar.png') }}" alt="Avatar" class="w-12 h-12 rounded-full object-cover mr-4">
                    <a href="{{ route('profile.show', $user->username) }}" class="text-lg font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                        {{ $user->username }}
                    </a>
                </div>
            @empty
                <p class="text-gray-600 dark:text-gray-400">Aucun utilisateur trouvé.</p>
            @endforelse
        </div>

        <!-- Résultats Équipes-->
        <div class="mb-10">
            <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">🏆 Équipes</h2>
            @forelse ($teams as $team)
                <div class="mb-4 bg-white dark:bg-gray-800 p-4 rounded-lg shadow hover:shadow-lg transition">
                    <a href="{{ route('teams.show', $team->id) }}" class="text-lg font-semibold text-green-600 dark:text-green-400 hover:underline">
                        {{ $team->name }}
                    </a>
                </div>
            @empty
                <p class="text-gray-600 dark:text-gray-400">Aucune équipe trouvée.</p>
            @endforelse
        </div>

        <!-- Résultats Posts -->
        <div class="mb-10">
            <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">📝 Posts</h2>

            <div class="mt-6 space-y-6">
                @forelse ($posts as $post)
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">

                        @if ($post->sport)
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-3 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">
                            ⚽ {{ $post->sport->name }}
                        </span>
                        @endif

                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $post->title }}</h2>

                        <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $post->content }}</p>

                        @if ($post->image)
                            <div class="mt-4">
                                <img src="{{ Storage::url($post->image) }}" class="w-full max-w-[400px] max-h-[300px] object-contain rounded-lg" alt="Image du post">
                            </div>
                        @endif

                        <div class="flex justify-between items-center mt-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400">🗓 Publié {{ $post->created_at ? $post->created_at->diffForHumans() : 'Date inconnue' }}</span>
                            <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
                            ✍️ <a href="{{ route('profile.show', $post->user->username) }}" class="hover:underline">{{ $post->user->username }}</a>
                        </span>
                        </div>

                        <div class="mt-2 flex items-center space-x-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400 likes-count" data-post-id="{{ $post->id }}">
                            {{ $post->likedBy()->count() }}
                        </span>
                            @if (Auth::check())
                                <button class="text-sm like-button {{ Auth::user()->likes()->where('post_id', $post->id)->exists() ? 'text-red-500' : 'text-gray-400' }}"
                                        data-post-id="{{ $post->id }}"
                                        data-action="{{ Auth::user()->likes()->where('post_id', $post->id)->exists() ? 'unlike' : 'like' }}">
                                    ❤️
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 dark:text-gray-400">Aucun post trouvé.</p>
                @endforelse
            </div>
        </div>

    </div>
@endsection
