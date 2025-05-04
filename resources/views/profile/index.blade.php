@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-4">
        <!-- Avatar et bannière -->
        <div class="relative">
            <!--<img src="{{ $user->banner }}" class="w-full h-40 object-cover rounded-lg" alt="Bannière">-->
            @if($user->avatar)
                <div class="mb-2">
                    <img src="{{ Storage::url($user->avatar) }}" class="w-40 h-40 top-0 left-0 rounded-full border-4 border-white shadow-lg" alt="Avatar actuel">
                </div>
            @else
                <div class="mb-2">
                    <img src="{{ asset('images/profile.png') }}" class="w-40 h-40 top-0 left-0 rounded-full border-4 border-white shadow-lg" alt="Avatar actuel">
                </div>
            @endif
        </div>

        <!-- Informations de l'utilisateur -->
        <div class="mt-2 p-4">
            <h1 class="text-2xl font-bold text-white">
                {{ $user->username }}
                @if($user->verified)
                    <span class="text-blue-500">✔</span>
                @endif
            </h1>
            <p class="text-white">{{ $user->name }} {{ $user->lastname }}</p>

            <!-- Bio -->
            @if($user->bio)
                <p class="mt-2 text-white">{{ $user->bio }}</p>
            @endif

            <!-- Sports favoris -->
            <div class="mt-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Sports favoris :</h2>
                @if ($user->favoriteSports->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">Aucun sport favori sélectionné.</p>
                @else
                    <ul class="list-disc list-inside mt-2">
                        @foreach ($user->favoriteSports as $sport)
                            <li class="text-gray-700 dark:text-gray-300">{{ $sport->name }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Team -->
            <div class="mt-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Team :</h2>
                @if ($user->teams()->count() === 0)
                    <p class="text-gray-500 dark:text-gray-400">Ne fais parti d'aucune équipe.</p>
                @else
                    <p class="text-blue-500">
                        <a href="{{ route('teams.show', $user->teams()->first()->id) }}" class="font-semibold hover:underline">
                        {{ $user->teams()->first()->name }}
                        </a>
                    </p>
                @endif
            </div>

            <!-- Localisation et date d'inscription -->
            <div class="mt-2 text-white flex items-center space-x-4">
                @if($user->location)
                    <span>📍 {{ $user->location }}</span>
                @endif
                <span>&nbsp&nbsp&nbsp&nbsp📅 A rejoint en {{ $user->created_at->format('F Y') }}</span>
            </div>

            <!-- Nombre d'abonnés et d'abonnements -->
            <div class="mt-2 flex items-center space-x-4">
                <span class="font-bold text-white">{{ $user->followers->count() }}</span>
                <span class="text-white">abonnés,</span>
                <span class="font-bold text-white">{{ $user->following->count() }}</span>
                <span class="text-white">abonnements</span>
            </div>
        </div>

        <!-- Bouton Follow/Unfollow -->
        @if (Auth::check() && Auth::id() !== $user->id)
            <div class="mt-6 mb-6">
                @if ($isFollowing)
                    <form action="{{ route('profile.unfollow', $user->username) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            Ne plus suivre
                        </button>
                    </form>
                @else
                    <form action="{{ route('profile.follow', $user->username) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Suivre
                        </button>
                    </form>
                @endif
            </div>
        @endif

        <!-- Bouton Modifier le profil (visible uniquement pour l'utilisateur connecté) -->
        @if (Auth::check() && Auth::id() === $user->id)
            <div class="mt-6 mb-6">
                <a href="{{ route('profile.edit') }}"
                   class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Modifier le profil
                </a>
            </div>
        @endif

        @admin
        <div class="mt-4 flex justify-end">
            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Supprimer
                </button>
            </form>
        </div>
        @endadmin

        <!-- Navigation -->
        <div class="border-b">
            <div class="flex justify-around text-gray-500">
                <a href="{{ route('profile.show', $user->username) }}?tab=posts"
                   class="py-2 px-4 {{ $tab === 'posts' ? 'font-bold text-white border-b-2 border-black' : '' }}">
                    Posts
                </a>
                <a href="{{ route('profile.show', $user->username) }}?tab=followers"
                   class="py-2 px-4 {{ $tab === 'followers' ? 'font-bold text-white border-b-2 border-black' : '' }}">
                    Abonnés
                </a>
                <a href="{{ route('profile.show', $user->username) }}?tab=following"
                   class="py-2 px-4 {{ $tab === 'following' ? 'font-bold text-white border-b-2 border-black' : '' }}">
                    Abonnements
                </a>
            </div>
        </div>

        <!-- Contenu de l'onglet -->
        <div class="mt-4">
            @if($tab === 'posts')
                <!-- Liste des posts -->
                @forelse($user->posts as $post)
                    <div class="p-4 border-b">
                        <!-- Titre du post -->
                        @if($post->title)
                            <h3 class="text-lg font-semibold text-white">{{ $post->title }}</h3>
                        @endif

                        <!-- Contenu du post -->
                        <p class="mt-2 text-white">{{ $post->content }}</p>

                        <!-- Image du post -->
                        @if($post->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $post->image) }}" class="w-100 h-100 object-contain rounded-lg" alt="Image du post">
                            </div>
                        @endif

                        <!-- Date de publication -->
                        <div class="text-white text-sm mt-2">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                @empty
                    <div class="p-4 text-white">
                        Aucun post pour le moment.
                    </div>
                @endforelse

            @elseif($tab === 'followers')
                <!-- Liste des abonnés -->
                @forelse($user->followers as $follower)
                    <div class="p-4 border-b flex items-center space-x-4">
                        <img src="{{ Storage::url($follower->avatar) ?? asset('images/profile.png')  }}" class="w-12 h-12 rounded-full" alt="Avatar de l'abonné">
                        <div>
                            <a href="{{ route('profile.show', $follower->username) }}" class="font-semibold text-white hover:underline">
                                {{ $follower->username }}
                                @if($follower->verified)
                                    <span class="text-blue-500">✔</span>
                                @endif
                            </a>
                            <p class="text-white">{{ $follower->name }} {{ $follower->lastname }}</p>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-white">
                        Aucun abonné pour le moment.
                    </div>
                @endforelse

            @elseif($tab === 'following')
                <!-- Liste des abonnements -->
                @forelse($user->following as $followed)
                    <div class="p-4 border-b flex items-center space-x-4">
                        <img src="{{ Storage::url($followed->avatar) ?? asset('images/profile.png')  }}" class="w-12 h-12 rounded-full" alt="Avatar de l'abonnement">
                        <div>
                            <a href="{{ route('profile.show', $followed->username) }}" class="font-semibold text-white hover:underline">
                                {{ $followed->username }}
                                @if($followed->verified)
                                    <span class="text-blue-500">✔</span>
                                @endif
                            </a>
                            <p class="text-white">{{ $followed->name }} {{ $followed->lastname }}</p>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-white">
                        Aucun abonnement pour le moment.
                    </div>
                @endforelse
            @endif
        </div>
    </div>
@endsection
