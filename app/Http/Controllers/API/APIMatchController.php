<?php
/*
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class APIMatchController extends Controller
{
    public function index()
    {
        $response = Http::get('https://api.sportmonks.com/v3/football/matches', [
            'api_token' => '4d6f3cfb135e463fbf2d8fa1a3a815d0',
            'league_id' => 5, // ID de Ligue 1
        ]);

        $matches = $response->json()['data'];

        return view('welcome', compact('matches'));
    }
}
*/
