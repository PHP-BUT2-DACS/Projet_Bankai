<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class SportsMatchController extends Controller
{
    protected $footballApiToken = '9b5707515483469fa6fc1f605bea8383';
    protected $apiSportsToken = '965f9473d0f6c1770b1584428c74cd12';

    public function index(Request $request)
    {
        // Récupérer la date et le sport depuis les paramètres GET
        $matchDate = $request->input('match_date', Carbon::today()->format('Y-m-d'));
        $sport = $request->input('sport', 'football'); // Par défaut: football

        // Valider la date
        try {
            $date = Carbon::parse($matchDate)->format('Y-m-d');
        } catch (\Exception $e) {
            $date = Carbon::today()->format('Y-m-d');
        }

        $matches = [];
        $error = null;

        // Récupérer les matchs selon le sport sélectionné
        switch ($sport) {
            case 'football':
                $matches = $this->getFootballMatches($date);
                break;
            case 'basketball':
                $matches = $this->getBasketballMatches($date);
                break;
            case 'formula1':
                $matches = $this->getFormula1Races($date);
                break;
        }

        return view('matches.index', compact('matches', 'error', 'sport', 'date'));
    }

    /**
     * Récupérer les matchs de football pour une date donnée
     */
    private function getFootballMatches($date)
    {
        // Utiliser l'API Football-Data.org
        $response = Http::withHeaders([
            'X-Auth-Token' => $this->footballApiToken,
        ])->get('https://api.football-data.org/v4/matches', [
            'dateFrom' => $date,
            'dateTo' => $date,
        ]);

        if ($response->successful()) {
            return $response->json()['matches'] ?? [];
        }

        return [];
    }

    /**
     * Récupérer les matchs de basketball pour une date donnée
     */
    private function getBasketballMatches($date)
    {
        // Utiliser l'API Basketball
        $response = Http::withHeaders([
            'x-apisports-key' => $this->apiSportsToken,
        ])->get('https://v1.basketball.api-sports.io/games', [
            'date' => $date,
        ]);

        if ($response->successful()) {
            return $response->json()['response'] ?? [];
        }

        return [];
    }

    /**
     * Récupérer les courses de Formule 1 pour une date donnée
     */
    private function getFormula1Races($date)
    {
        // Utiliser l'API Formula 1
        $response = Http::withHeaders([
            'x-rapidapi-host' => 'api-formula-1.p.rapidapi.com',
            'x-rapidapi-key' => $this->apiSportsToken,
        ])->get('https://api-formula-1.p.rapidapi.com/races', [
            'date' => $date,
        ]);

        if ($response->successful()) {
            return $response->json()['response'] ?? [];
        }

        return [];
    }
}
