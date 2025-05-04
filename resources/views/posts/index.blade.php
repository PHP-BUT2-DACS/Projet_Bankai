@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-10">
        <div class="mt-6">
            <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-4">📢 Derniers Articles Sportifs</h1>

            <!-- Afficher les messages de succès ou d'erreur -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Bouton pour basculer entre "Tous les posts" et "Mes sports favoris" -->
            @if (Auth::check() && Auth::user()->favoriteSports()->count() > 0)
                <div class="flex justify-center mb-4">
                    <a href="{{ route('posts.index', ['filter' => 'all']) }}"
                       class="px-4 py-2 mr-2 rounded-lg {{ request('filter') != 'favorites' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}">
                        Tous les sports
                    </a>
                    <a href="{{ route('posts.index', ['filter' => 'favorites']) }}"
                       class="px-4 py-2 rounded-lg {{ request('filter') == 'favorites' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}">
                        Mes sports favoris
                    </a>
                </div>
            @endif

            <!-- Liste des posts -->
            <div class="mt-6 space-y-6">
                @php
                    // Déterminer quels posts afficher
                    $displayPosts = $posts;

                    // Si l'utilisateur est connecté et a des sports favoris et si le filtre est activé
                    if (Auth::check() && Auth::user()->favoriteSports()->count() > 0 && request('filter') == 'favorites') {
                        $favoriteSportIds = Auth::user()->favoriteSports()->pluck('sports.id')->toArray();
                        $displayPosts = $posts->filter(function($post) use ($favoriteSportIds) {
                            return $post->sport_id && in_array($post->sport_id, $favoriteSportIds);
                        });
                    }
                @endphp

                @forelse ($displayPosts as $post)
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">

                        @if ($post->sport)
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-3 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                ⚽ {{ $post->sport->name }}
                            </span>
                        @endif

                        <!-- Titre du post -->
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $post->title }}</h2>

                        <!-- Contenu du post -->
                        <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $post->content }}</p>

                        <!-- Image du post -->
                        @if ($post->image)
                            <div class="mt-4">
                                <img src="{{ asset('storage/' . $post->image) }}" class="w-full max-w-[400px] max-h-[300px] object-contain rounded-lg" alt="Image du post">
                            </div>
                        @endif

                        <!-- Informations sur le post -->
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400">🗓 Publié {{ $post->created_at ? $post->created_at->diffForHumans() : 'Date inconnue' }}</span>
                            <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                ✍️ <a href="{{ route('profile.show', $post->user->username) }}" class="hover:underline">{{ $post->user->username }}</a>
                            </span>
                        </div>

                        <!-- Likes -->
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

                        <!-- Bouton de suppression (visible uniquement pour l'auteur) -->
                        @if (Auth::check() && (Auth::id() === $post->user_id || (Auth::user()->role === 'admin')))
                            <div class="mt-4 flex justify-end">
                                <form action="{{ Auth::user()->role === 'admin' ? route('admin.posts.delete', $post->id) : route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce post ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md text-gray-500">
                        @if (Auth::check() && Auth::user()->favoriteSports()->count() > 0 && request('filter') == 'favorites')
                            Aucun post concernant vos sports favoris pour le moment.
                        @else
                            Aucun post pour le moment.
                        @endif
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
