<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class APIClubController extends Controller
{
    public function show($id)
    {
        // Récupération des informations du club via l'API
        $clubResponse = Http::get("https://api.football-data.org/v4/teams/{$id}", [
            'X-Auth-Token' => '9b5707515483469fa6fc1f605bea8383',
        ]);

        $club = $clubResponse->json();

        // Récupération du calendrier des matchs du club via l'API
        $fixturesResponse = Http::get("https://api.football-data.org/v4/teams/{$id}/matches", [
            'X-Auth-Token' => '9b5707515483469fa6fc1f605bea8383',
        ]);

        $fixtures = $fixturesResponse->json()['matches'];

        // Retourner la vue avec les données du club et son calendrier
        return view('clubs.show', compact('club', 'fixtures'));
    }
}
