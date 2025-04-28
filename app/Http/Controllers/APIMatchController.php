<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class APIMatchController extends Controller
{
    public function index()
    {
        $response = Http::get('https://api.sportmonks.com/v3/football/matches', [
            'api_token' => '8Js7PrcEO1JzsHci65kWPzX7OE07twyX3ZdcwfcL4U3WKt1TJ963Y1WUQpAS',
            'league_id' => 5, // ID de Ligue 1
        ]);

        $matches = $response->json()['data'];

        return view('welcome', compact('matches'));
    }

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
}
