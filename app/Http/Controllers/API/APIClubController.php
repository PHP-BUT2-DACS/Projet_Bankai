<?php
/*
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class APIClubController extends Controller
{
    public function show($id)
    {
        // Récupération des informations du club via l'API
        $clubResponse = Http::get("https://api.football-data.org/v4/teams/{$id}", [
            'X-Auth-Token' => '4d6f3cfb135e463fbf2d8fa1a3a815d0',
        ]);

        $club = $clubResponse->json();

        // Récupération du calendrier des matchs du club via l'API
        $fixturesResponse = Http::get("https://api.football-data.org/v4/teams/{$id}/matches", [
            'X-Auth-Token' => '4d6f3cfb135e463fbf2d8fa1a3a815d0',
        ]);

        $fixtures = $fixturesResponse->json()['matches'];

        // Retourner la vue avec les données du club et son calendrier
        return view('clubs.show', compact('club', 'fixtures'));
    }
}
*/
