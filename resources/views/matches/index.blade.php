@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-10">
        <!-- Système d'onglets -->
        <div class="border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                <li class="me-2">
                    <a href="{{ route('posts.index') }}"
                       class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                        Posts
                    </a>
                </li>
                <li class="me-2">
                    <a href="{{ route('matches.index') }}"
                       class="inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group"
                       aria-current="page">
                        Matchs
                    </a>
                </li>
            </ul>
        </div>

        <!-- Contenu de l'onglet Matchs -->
        <div class="mt-6">
            <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white">⚽ Matchs de Ligue 1</h1>

            @if (empty($matches))
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md text-gray-500">
                    Aucun match disponible pour le moment.
                </div>
            @else
                <div class="space-y-6">
                    @foreach ($matches as $match)
                        <div
                            class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
                            <!-- Détails du match -->
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-4">
                                    <!-- Équipe à domicile -->
                                    <span class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $match['home_team']['name'] ?? 'Équipe inconnue' }}
                                    </span>
                                    <span class="text-gray-500">vs</span>
                                    <!-- Équipe à l'extérieur -->
                                    <span class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $match['away_team']['name'] ?? 'Équipe inconnue' }}
                                    </span>
                                </div>
                                <!-- Score ou statut -->
                                @if (isset($match['scores']['full_time']))
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">
                                        {{ $match['scores']['full_time']['home'] ?? '-' }} - {{ $match['scores']['full_time']['away'] ?? '-' }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ Carbon::parse($match['starting_at'])->format('d/m/Y H:i') }}
                                    </span>
                                @endif
                            </div>
                            <!-- Statut du match -->
                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Statut : {{ $match['status'] ?? 'Inconnu' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
