<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class SFFilmesController extends Controller
{
    public function getDataFromApi(){

        
       // $token = 'ji31VSqbvKyZYDU8sslnVXJ3r';

        $response = Http::get('https://data.sfgov.org/resource/yitu-d5am.json?$limit=10&$$app_token=ji31VSqbvKyZYDU8sslnVXJ3r');
        return $response->json();
    }
}
