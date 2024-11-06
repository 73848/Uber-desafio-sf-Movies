<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class SFFilmesController extends Controller
{

    public function getallDataFromApi()
    {
        try {
            $response = Http::timeout(16)->get('https://data.sfgov.org/resource/yitu-d5am.json?', [
                '$$app_token' => env("SODA_API_KEY"),
            ]);
            $response = json_encode($response->json());
            return $response;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getingGeoLocationFromAdress(String $adress)
    {
        try {
          /*   $input = $request->validate(['search-location' => 'required']);
            $adress = strip_tags($input['search-location']); */
            $url = "https://maps.googleapis.com/maps/api/geocode/json?&key=";
            $response = Http::timeout(5)->get(
                $url,
                [
                    'key' => env('GOOGLE_MAPS_API_KEY'),
                    'city' => 'San Francisco',
                    'country' => 'United States of America',
                    'state' => 'California',
                    'address' => $adress
                ]
            );
            $location = ($response->collect()->first());
            // ENVIANDO LONG E LAT FORMATO JSON
            $location =  json_encode($location[0]['geometry']['location']);
            $location_json =  response()->json(['location'=>$location]);
            return $location_json->getData()->location;

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getAllMovies(){
        $result = Movie::all();
        $movies = json_encode($result);
        return response()->json(['movies'=>$movies]); 
    }
}
