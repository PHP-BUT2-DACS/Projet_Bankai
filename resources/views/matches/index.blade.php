@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-10">

        <!-- Contenu de l'onglet Matchs -->
        <div class="mt-6">
            <!-- Titre avec la date sélectionnée -->
            <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white">
                ⚽ Matchs du {{ Carbon::parse(request('match_date', now()))->format('d/m/Y') }}
            </h1>

            <!-- Formulaire de filtre par date -->
            <form method="GET" action="{{ route('matches.index') }}" class="mt-4 flex justify-center">
                <div class="flex items-center space-x-4">
                    <label for="match_date" class="text-gray-700 dark:text-gray-300">Choisir une date :</label>
                    <input type="date" name="match_date" id="match_date"
                           value="{{ request('match_date', now()->format('Y-m-d')) }}"
                           class="border rounded-lg p-2 dark:bg-gray-700 dark:text-white">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Filtrer
                    </button>
                </div>
            </form>

            <!-- Afficher les erreurs -->
            @if (isset($error))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 mt-4" role="alert">
                    {{ $error }}
                </div>
            @endif

            <!-- Liste des matchs -->
            @if (empty($matches))
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md text-gray-500 mt-4">
                    Aucun match disponible pour cette date.
                </div>
            @else
                <div class="space-y-6 mt-4">
                    @foreach ($matches as $match)
                        <div
                            class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
                            <!-- Détails du match -->
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-4">
                                    <!-- Logo et nom de l'équipe à domicile -->
                                    <div class="flex items-center space-x-2">
                                        @if (isset($match['homeTeam']['crest']))
                                            <img src="{{ $match['homeTeam']['crest'] }}"
                                                 alt="{{ $match['homeTeam']['name'] }} logo" class="w-8 h-8">
                                        @endif
                                        <span class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $match['homeTeam']['name'] ?? 'Équipe inconnue' }}
                                        </span>
                                    </div>
                                    <span class="text-gray-500">vs</span>
                                    <!-- Logo et nom de l'équipe à l'extérieur -->
                                    <div class="flex items-center space-x-2">
                                        @if (isset($match['awayTeam']['crest']))
                                            <img src="{{ $match['awayTeam']['crest'] }}"
                                                 alt="{{ $match['awayTeam']['name'] }} logo" class="w-8 h-8">
                                        @endif
                                        <span class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $match['awayTeam']['name'] ?? 'Équipe inconnue' }}
                                        </span>
                                    </div>
                                </div>
                                <!-- Score ou heure -->
                                @if ($match['status'] === 'FINISHED' && isset($match['score']['fullTime']['home']) && $match['score']['fullTime']['home'] !== null)
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">
                                        {{ $match['score']['fullTime']['home'] }} - {{ $match['score']['fullTime']['away'] }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ Carbon::parse($match['utcDate'])->format('H:i') }}
                                    </span>
                                @endif
                            </div>
                            <!-- Ligue et statut -->
                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                <span>Ligue : {{ $match['competition']['name'] ?? 'Inconnue' }}</span> |
                                <span>Statut : {{ $match['status'] ?? 'Inconnu' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
