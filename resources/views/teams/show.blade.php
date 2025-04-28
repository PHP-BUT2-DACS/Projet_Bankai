@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-8">
        @if (session('success'))
            <div class="bg-green-500 text-white p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500 text-white p-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-300">{{ $team->name }}</h1>
        <p class="text-gray-600 dark:text-gray-400">Sport : {{ $team->sport->name ?? 'Inconnu' }}</p>

        <h2 class="mt-6 text-xl font-semibold text-gray-700 dark:text-gray-300">Membres :</h2>
        <ul class="list-disc ml-6 mt-2">
            @forelse($team->users as $member)
                <div class="p-4 border-b flex items-center space-x-4">
                    <img src="{{ $member->avatar ? Storage::url($member->avatar) : asset('images/profile.png') }}" class="w-12 h-12 rounded-full" alt="Avatar de l'utilisateur">
                    <div>
                        <a href="{{ route('profile.show', $member->username) }}" class="font-semibold text-white hover:underline">
                            {{ $member->username }}
                            @if($member->verified)
                                <span class="text-blue-500">✔</span>
                            @endif
                        </a>
                        <p class="text-white">{{ $member->name }} {{ $member->lastname }}</p>
                    </div>
                </div>
            @empty
                <div class="text-gray-700 dark:text-gray-300">Aucun membre pour le moment.</div>
            @endforelse
        </ul>

        <div class="mt-6">
            @if (!$isMember)
                <form action="{{ route('teams.join', $team->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Rejoindre l'équipe
                    </button>
                </form>
            @else
                <form action="{{ route('teams.leave', $team->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                        Quitter l'équipe
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection
