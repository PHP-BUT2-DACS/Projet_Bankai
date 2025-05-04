<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BasketAPIController extends Controller
{
    protected $apiBaseUrl = 'https://v1.basketball.api-sports.io';
    protected $apiToken = '965f9473d0f6c1770b1584428c74cd12'; // Mets ta clé ici

    // 1. Récupérer les ligues (optionnel : filtrer par pays ou saison)
    public function leagues(Request $request)
    {
        $query = [];
        if ($request->filled('country')) $query['country'] = $request->input('country');
        if ($request->filled('season')) $query['season'] = $request->input('season');

        $response = Http::withHeaders([
            'x-apisports-key' => $this->apiToken,
        ])->get($this->apiBaseUrl . '/leagues', $query);

        return $this->apiResponse($response, 'ligues');
    }

    // 2. Récupérer les clubs/équipes d'une ligue et d'une saison
    public function clubs(Request $request)
    {
        $query = [];
        if ($request->filled('league')) $query['league'] = $request->input('league');
        if ($request->filled('season')) $query['season'] = $request->input('season');

        $response = Http::withHeaders([
            'x-apisports-key' => $this->apiToken,
        ])->get($this->apiBaseUrl . '/teams', $query);

        return $this->apiResponse($response, 'clubs');
    }

    // 3. Récupérer les matchs selon ligue, saison, équipe (et date optionnelle)
    public function matches(Request $request)
    {
        $query = [];
        if ($request->filled('league')) $query['league'] = $request->input('league');
        if ($request->filled('season')) $query['season'] = $request->input('season');
        if ($request->filled('team')) $query['team'] = $request->input('team');
        if ($request->filled('date')) $query['date'] = $request->input('date');

        $response = Http::withHeaders([
            'x-apisports-key' => $this->apiToken,
        ])->get($this->apiBaseUrl . '/games', $query);

        return $this->apiResponse($response, 'matchs');
    }

    // Méthode utilitaire pour unifier les réponses
    private function apiResponse($response, $type)
    {
        if ($response->failed()) {
            return response()->json([
                'error' => "Erreur lors de la récupération des $type",
                'details' => $response->body(),
            ], $response->status());
        }
        return response()->json($response->json('response'));
    }
}
