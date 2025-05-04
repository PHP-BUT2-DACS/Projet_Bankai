@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-10">
        <!-- Titre avec la date et le sport sélectionnés -->
        <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white">
            @if($sport == 'football')
                ⚽ Matchs de football
            @elseif($sport == 'basketball')
                🏀 Matchs de basketball
            @elseif($sport == 'formula1')
                🏎️ Courses de Formule 1
            @endif
            du {{ Carbon::parse($date)->format('d/m/Y') }}
        </h1>

        <!-- Formulaire de filtre par date et sport -->
        <form method="GET" action="{{ route('matches.index') }}" class="mt-6 flex flex-col md:flex-row justify-center items-center gap-4">
            <div class="flex items-center space-x-4">
                <label for="sport" class="text-gray-700 dark:text-gray-300">Sport :</label>
                <select name="sport" id="sport" class="border rounded-lg p-2 dark:bg-gray-700 dark:text-white">
                    <option value="football" {{ $sport == 'football' ? 'selected' : '' }}>Football</option>
                    <option value="basketball" {{ $sport == 'basketball' ? 'selected' : '' }}>Basketball</option>
                    <option value="formula1" {{ $sport == 'formula1' ? 'selected' : '' }}>Formule 1</option>
                </select>
            </div>

            <div class="flex items-center space-x-4">
                <label for="match_date" class="text-gray-700 dark:text-gray-300">Date :</label>
                <input type="date" name="match_date" id="match_date"
                       value="{{ $date }}"
                       class="border rounded-lg p-2 dark:bg-gray-700 dark:text-white">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Filtrer
            </button>
        </form>

        <!-- Afficher les erreurs -->
        @if (isset($error))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 mt-6" role="alert">
                {{ $error }}
            </div>
        @endif

        <!-- Liste des matchs/événements selon le sport -->
        @if (empty($matches))
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md text-gray-500 mt-6">
                Aucun événement disponible pour cette date.
            </div>
        @else
            <div class="space-y-6 mt-6">
                @if($sport == 'football')
                    @foreach ($matches as $match)
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
                            <!-- Détails du match de football -->
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-4">
                                    <!-- Équipe à domicile -->
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
                                    <!-- Équipe à l'extérieur -->
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
                @elseif($sport == 'basketball')
                    @foreach ($matches as $match)
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
                            <!-- Détails du match de basketball -->
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-4">
                                    <!-- Équipe à domicile -->
                                    <div class="flex items-center space-x-2">
                                        @if (isset($match['teams']['home']['logo']))
                                            <img src="{{ $match['teams']['home']['logo'] }}"
                                                 alt="{{ $match['teams']['home']['name'] }} logo" class="w-8 h-8">
                                        @endif
                                        <span class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $match['teams']['home']['name'] ?? 'Équipe inconnue' }}
                                        </span>
                                    </div>
                                    <span class="text-gray-500">vs</span>
                                    <!-- Équipe à l'extérieur -->
                                    <div class="flex items-center space-x-2">
                                        @if (isset($match['teams']['away']['logo']))
                                            <img src="{{ $match['teams']['away']['logo'] }}"
                                                 alt="{{ $match['teams']['away']['name'] }} logo" class="w-8 h-8">
                                        @endif
                                        <span class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $match['teams']['away']['name'] ?? 'Équipe inconnue' }}
                                        </span>
                                    </div>
                                </div>
                                <!-- Score ou heure -->
                                @if (isset($match['scores']) && isset($match['scores']['home']['total']) && $match['scores']['home']['total'] !== null)
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">
                                        {{ $match['scores']['home']['total'] }} - {{ $match['scores']['away']['total'] }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ Carbon::parse($match['date'])->format('H:i') }}
                                    </span>
                                @endif
                            </div>
                            <!-- Ligue et statut -->
                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                <span>Ligue : {{ $match['league']['name'] ?? 'Inconnue' }}</span> |
                                <span>Statut : {{ $match['status']['long'] ?? 'Inconnu' }}</span>
                            </div>
                        </div>
                    @endforeach
                @elseif($sport == 'formula1')
                    @foreach ($matches as $race)
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
                            <!-- Détails de la course de Formule 1 -->
                            <div class="flex flex-col">
                                <div class="flex justify-between items-center">
                                    <!-- Nom du Grand Prix et circuit -->
                                    <div class="flex flex-col">
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                            {{ $race['competition']['name'] ?? $race['name'] ?? 'Grand Prix' }}
                                        </h3>
                                        <span class="text-md text-gray-700 dark:text-gray-300">
                            {{ $race['circuit']['name'] ?? 'Circuit inconnu' }}
                        </span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $race['circuit']['location']['city'] ?? '' }}{{ isset($race['circuit']['location']['country']) ? ', ' . $race['circuit']['location']['country'] : '' }}
                        </span>
                                    </div>

                                    <!-- Date et statut -->
                                    <div class="flex flex-col items-end">
                        <span class="text-md font-medium text-gray-900 dark:text-white">
                            {{ Carbon::parse($race['date'] ?? $race['datetime'] ?? '')->format('d/m/Y') }}
                        </span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ Carbon::parse($race['date'] ?? $race['datetime'] ?? '')->format('H:i') }}
                        </span>
                                        <span class="text-sm font-medium px-2 py-1 rounded-full {{ isset($race['status']) && $race['status'] == 'Completed' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' }}">
                            {{ $race['status'] ?? 'À venir' }}
                        </span>
                                    </div>
                                </div>

                                <!-- Informations supplémentaires si disponibles -->
                                @if(isset($race['season']))
                                    <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                                        <span>Saison: {{ $race['season'] }}</span>
                                        @if(isset($race['round']))
                                            | <span>Manche: {{ $race['round'] }}</span>
                                        @endif
                                        @if(isset($race['laps']))
                                            | <span>Tours: {{ $race['laps']['total'] ?? $race['laps'] }}</span>
                                        @endif
                                        @if(isset($race['distance']))
                                            | <span>Distance: {{ $race['distance'] }}</span>
                                        @endif
                                    </div>
                                @endif

                                <!-- Résultats si la course est terminée -->
                                @if(isset($race['status']) && $race['status'] == 'Completed' && isset($race['results']))
                                    <div class="mt-4">
                                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Podium:</h4>
                                        <div class="space-y-2">
                                            @foreach(array_slice($race['results'], 0, 3) as $index => $result)
                                                <div class="flex items-center space-x-3">
                                <span class="font-bold w-6 text-center {{ $index === 0 ? 'text-yellow-500' : ($index === 1 ? 'text-gray-400' : 'text-amber-700') }}">
                                    {{ $index + 1 }}
                                </span>
                                                    <span class="font-medium text-gray-800 dark:text-gray-200">
                                    {{ $result['driver']['name'] ?? 'Pilote inconnu' }}
                                </span>
                                                    <span class="text-gray-600 dark:text-gray-400">
                                    {{ $result['team']['name'] ?? 'Équipe inconnue' }}
                                </span>
                                                    @if(isset($result['time']))
                                                        <span class="text-sm text-gray-500 ml-auto">
                                    {{ $result['time'] }}
                                </span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        @endif
    </div>
@endsection
