<?php

namespace App\Http\Controllers;

use App\Models\Get;
use Illuminate\Http\Request;

class GetController extends Controller
{
    public function GetUser(){
        return view('getUser', [
            'users' => Get::all()
        ]);
    }

    public function GetSport(){
        return view('getSport', [
            'sports' => Get::all()
        ]);
    }


}
