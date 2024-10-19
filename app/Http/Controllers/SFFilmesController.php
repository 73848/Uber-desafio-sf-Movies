<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class SFFilmesController extends Controller
{
    public function getDataFromApi(){
        
        $limit = 5;
      
         $response = Http::timeout(5)->get('https://data.sfgov.org/resource/yitu-d5am.json?', [
            '$limit'=>$limit ,
            '$$app_token'=>env("SODA_API_KEY"),
        ]);  
        $response = json_encode($response->json());
        return $response;
    }
    public function getDataFromApiWithLocalName(){
        try {
            $response = Http::timeout(5)->get('https://data.sfgov.org/resource/yitu-d5am.json?', [
                '$$app_token'=>env("SODA_API_KEY"),
                'title'=> 'Chan is Missing'
            ]);     
            $response = json_encode($response->json());
            return $response; 
        } catch (\Throwable $th) {
            throw $th;
        }
       
    }
    public function getingGeoLocationFromAdress(){
        try {
            $url = "https://nominatim.openstreetmap.org/search?";
            $street = 'Union St';
            $response = Http::timeout(5)->withHeaders([
                'User-Agent' => 'uber-desafio/1.0 (clemesonsilva736@gmail.com)'
            ])->get($url, 
            [
                'format'=> 'json',
                'city'=> 'San Francisco',
                'country'=> 'United States of America',
                'state'=>'California',
                'street'=> $street
            ]
        );
        $response = $response->collect()->first();
        return $response;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
}
