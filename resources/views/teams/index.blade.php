
@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-300">Liste des équipes</h1>
            <a href="{{ route('teams.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                + Créer une équipe
            </a>
        </div>

        @foreach ($teams as $team_selected)
            <div class="border p-4 mb-4 rounded shadow">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">{{ $team_selected->name }}</h2>
                <p class="text-sm text-gray-500">Membres : {{ $team_selected->users_count }}</p>
                <a href="{{ route('teams.show', $team_selected->id) }}" class="text-blue-600 hover:underline mt-2 inline-block">
                    Voir l’équipe →
                </a>
            </div>
        @endforeach
    </div>
@endsection
