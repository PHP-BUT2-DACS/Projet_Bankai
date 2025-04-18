@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-10">
        <!-- Système d'onglets -->
        <div class="border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                <li class="me-2">
                    <a href="{{ route('posts.index') }}" class="inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group" aria-current="page">
                        Posts
                    </a>
                </li>
                <li class="me-2">
                    <a href="{{ route('matches.index') }}" class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                        Matchs
                    </a>
                </li>
            </ul>
        </div>

        <!-- Contenu de l'onglet Posts -->
        <div class="mt-6">
            <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white">📢 Derniers Articles Sportifs</h1>

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

            <!-- Liste des posts -->
            <div class="mt-6 space-y-6">
                @forelse ($posts as $post)
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
                        <!-- Titre du post -->
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $post->title }}</h2>

                        <!-- Contenu du post -->
                        <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $post->content }}</p>

                        <!-- Image du post -->
                        @if ($post->image)
                            <div class="mt-4">
                                <img src="{{ Storage::url($post->image) }}" class="w-full max-w-[400px] max-h-[300px] object-contain rounded-lg" alt="Image du post">
                            </div>
                        @endif

                        <!-- Informations sur le post -->
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400">🗓 Publié {{ $post->post_date ? $post->post_date->diffForHumans() : 'Date inconnue' }}</span>
                            <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                ✍️ <a href="{{ route('profile.show', $post->user->username) }}" class="hover:underline">{{ $post->user->username }}</a>
                            </span>
                        </div>

                        <!-- Likes -->
                        <div class="mt-2 flex items-center space-x-2">
                            <span class="text-sm text-gray-500 dark:text-gray-400 likes-count" data-post-id="{{ $post->id }}">❤️ {{ $post->likedBy()->count() }} likes</span>
                            @if (Auth::check())
                                @if (Auth::user()->likes()->where('post_id', $post->id)->exists())
                                    <!-- Bouton Unlike -->
                                    <button class="text-sm text-red-500 hover:underline like-button" data-post-id="{{ $post->id }}" data-action="unlike">Unlike</button>
                                @else
                                    <!-- Bouton Like -->
                                    <button class="text-sm text-blue-500 hover:underline like-button" data-post-id="{{ $post->id }}" data-action="like">Like</button>
                                @endif
                            @endif
                        </div>

                        <!-- Bouton de suppression (visible uniquement pour l'auteur) -->
                        @if (Auth::check() && Auth::id() === $post->user_id)
                            <div class="mt-4 flex justify-end">
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce post ?');">
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
                        Aucun post pour le moment.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
