
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
        <p class="text-gray-600">Sport : {{ $team->sport->name ?? 'Inconnu' }}</p>

        <h2 class="mt-6 text-xl font-semibold text-gray-700 dark:text-gray-300">Membres :</h2>
        <ul class="list-disc ml-6 mt-2">
            @forelse($team->users as $member)
                <li  class="text-gray-700 dark:text-gray-300">{{ $member->name }} ({{ $member->username }})</li>
            @empty
                <li class="text-gray-700 dark:text-gray-300">Aucun membre pour le moment.</li>
            @endforelse
        </ul>

        @if (!$isMember)
            <form action="{{ route('teams.join', $team->id) }}" method="POST" class="mt-6">
                @csrf
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Rejoindre l'équipe
                </button>
            </form>
        @else
            <p class="mt-6 text-green-600 font-medium">Vous êtes déjà membre de cette équipe.</p>
        @endif
    </div>
@endsection
