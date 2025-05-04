<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Formule1APIController extends Controller
{
    protected $apiBaseUrl = 'https://api-formula-1.p.rapidapi.com';
    protected $apiToken = '965f9473d0f6c1770b1584428c74cd12'; // Mets ta clé ici

    // 1. Récupérer les saisons disponibles
    public function seasons()
    {
        $response = Http::withHeaders([
            'x-rapidapi-host' => 'api-formula-1.p.rapidapi.com',
            'x-rapidapi-key' => $this->apiToken,
        ])->get($this->apiBaseUrl . '/seasons');

        return $this->apiResponse($response, 'saisons');
    }

    // 2. Récupérer les circuits (optionnel: filtrer par pays)
    public function circuits(Request $request)
    {
        $query = [];
        if ($request->filled('country')) $query['country'] = $request->input('country');

        $response = Http::withHeaders([
            'x-rapidapi-host' => 'api-formula-1.p.rapidapi.com',
            'x-rapidapi-key' => $this->apiToken,
        ])->get($this->apiBaseUrl . '/circuits', $query);

        return $this->apiResponse($response, 'circuits');
    }

    // 3. Récupérer les équipes (constructeurs) d'une saison
    public function teams(Request $request)
    {
        $query = [];
        if ($request->filled('season')) $query['season'] = $request->input('season');

        $response = Http::withHeaders([
            'x-rapidapi-host' => 'api-formula-1.p.rapidapi.com',
            'x-rapidapi-key' => $this->apiToken,
        ])->get($this->apiBaseUrl . '/teams', $query);

        return $this->apiResponse($response, 'équipes');
    }

    // 4. Récupérer les pilotes d'une saison ou d'une équipe
    public function drivers(Request $request)
    {
        $query = [];
        if ($request->filled('season')) $query['season'] = $request->input('season');
        if ($request->filled('team'))   $query['team']   = $request->input('team');

        $response = Http::withHeaders([
            'x-rapidapi-host' => 'api-formula-1.p.rapidapi.com',
            'x-rapidapi-key' => $this->apiToken,
        ])->get($this->apiBaseUrl . '/drivers', $query);

        return $this->apiResponse($response, 'pilotes');
    }

    // 5. Récupérer les courses (Grands Prix) selon saison, circuit, équipe, pilote
    public function races(Request $request)
    {
        $query = [];
        if ($request->filled('season'))  $query['season']  = $request->input('season');
        if ($request->filled('circuit')) $query['circuit'] = $request->input('circuit');
        if ($request->filled('team'))    $query['team']    = $request->input('team');
        if ($request->filled('driver'))  $query['driver']  = $request->input('driver');

        $response = Http::withHeaders([
            'x-rapidapi-host' => 'api-formula-1.p.rapidapi.com',
            'x-rapidapi-key' => $this->apiToken,
        ])->get($this->apiBaseUrl . '/races', $query);

        return $this->apiResponse($response, 'courses');
    }

    // Utilitaire pour uniformiser les réponses
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
