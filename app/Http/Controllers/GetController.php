<?php

namespace App\Http\Controllers;

use App\Models\Get;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GetController extends Controller
{
    public function GetUser(){
        return view('getUser', [
            'app_users' => Get::all()
        ]);
    }

    public function GetSport(){
        return view('getSport', [
            'sports' => Get::all()
        ]);
    }


}
