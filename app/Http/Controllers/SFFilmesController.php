<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class SFFilmesController extends Controller
{
    public function getDataFromApi(){
        $limit = 20000;
        $response = Http::timeout(16)->get('https://data.sfgov.org/resource/yitu-d5am.json?', [
          //  '$limit'=>$limit ,
            '$$app_token'=>env("SODA_API_KEY"),
        ]);  
        $response = json_encode($response->json());
        return $response;
    }
    public function getDataFromApiWithLocalName(){
        try {
            // lembre-se que a busca usando json usara o nome dos filmes como referencia e so daí que a localiz
        //zacao é enviada para a api de localizacoes para so assimser mostrada no mapa junto com a geolocalizacao
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
    public function getingGeoLocationFromAdress(Request $request){
        try {
            $adress = $request->validate(['adress'=>'required']);
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
                'street'=> $adress
            ]
        );
        $response = $response->collect()->first();
        return $response;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
}
