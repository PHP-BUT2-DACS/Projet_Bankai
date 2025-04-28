<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class APIMatchController extends Controller
{
    public function calendarEvents()
    {
        //$token = env('FOOTBALL_DATA_API_TOKEN'); // Place ton token dans .env
        $competition = 'PL'; // Par exemple Premier League, adapte selon ton besoin
        $response = Http::withHeaders([
            'X-Auth-Token' => "9b5707515483469fa6fc1f605bea8383",
        ])->get("https://api.football-data.org/v2/competitions/{$competition}/matches", [
            'status' => 'SCHEDULED', // ou 'FINISHED', etc.
        ]);

        $matches = [];
        if ($response->ok()) {
            foreach ($response->json('matches') as $match) {
                $matches[] = [
                    'id'    => 'match-' . $match['id'],
                    'title' => $match['homeTeam']['name'] . ' vs ' . $match['awayTeam']['name'],
                    'start' => $match['utcDate'],
                    'end'   => $match['utcDate'], // ou adapte si tu as la durée
                    'type'  => 'match',
                    'color' => '#e53935',
                ];
            }
        }

        return response()->json($matches);
    }

    public function index()
    {
        // Récupérer la date depuis le paramètre GET, ou utiliser la date du jour par défaut
        $matchDate = request('match_date', Carbon::today()->format('Y-m-d'));

        // Valider la date pour s'assurer qu'elle est au bon format
        try {
            $date = Carbon::parse($matchDate)->format('Y-m-d');
        } catch (\Exception $e) {
            $date = Carbon::today()->format('Y-m-d'); // Revenir à la date du jour en cas d'erreur
        }

        // Récupérer les matchs pour la date donnée via l'API Football-Data.org
        $response = Http::withHeaders([
            'X-Auth-Token' => '9b5707515483469fa6fc1f605bea8383',
        ])->get('https://api.football-data.org/v4/matches', [
            'dateFrom' => $date,
            'dateTo' => $date,
        ]);

        // Vérifier si la requête a réussi
        if ($response->failed()) {
            $error = 'Erreur lors de la récupération des matchs : ' . $response->status();
            $matches = [];
        } else {
            $error = null;
            $matches = $response->json()['matches'] ?? [];
        }

        return view('matches.index', compact('matches', 'error'));
    }
}
