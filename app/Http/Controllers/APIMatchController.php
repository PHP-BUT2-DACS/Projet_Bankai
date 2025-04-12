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
}
