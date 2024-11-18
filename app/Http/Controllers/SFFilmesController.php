<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Container\Attributes\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache as FacadesCache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SFFilmesController extends Controller
{

    public function getallDataFromApi($limit)
    {
        try {
            $response = Http::timeout(16)->get('https://data.sfgov.org/resource/yitu-d5am.json?', [
                '$$app_token' => env("SODA_API_KEY"),
                '$limit'=>$limit
            ]);
            $response = json_encode($response->json());
            return json_encode(response()->json(['movies'=>$response])->original); // retorna um json, obviamente. fiz essa gambiarra para tê-lo do outro lado de forma mais amigável (no futuro, pretendo corrigir isso)
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getingGeoLocationFromAdress(String $adress)
    {
        try {
            $url = "https://maps.googleapis.com/maps/api/geocode/json?&key=";
            $response = Http::timeout(5)->get(
                $url,
                [
                    'key' => env('GOOGLE_MAPS_API_KEY'),
                    'country' => 'United States of America',
                    'address' => $adress
                ]
            );
            $location = ($response->collect()->first());
            if(empty($location[0])){
                return json_encode([
                    'lat'=> 0,
                    'lng'=>0
                ]);
            }else {
                $location =  json_encode($location[0]['geometry']['location']);
                $location_json =  response()->json(['location'=>$location]);
                return $location_json->getData()->location;
               
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getAllMovies(){
        $movies = FacadesCache::remember('movie-maps', 60*5, function(){
           return json_encode(DB::select('SELECT * from movies'));
        });
        return response()->json(['movies'=>$movies]); 
    }
    public function getMoviesInformations(Request $request){
        try {
            $input = $request->validate(['movie'=>'required|string', 'address'=>'required|string']);
            $movieName = strip_tags($input['movie']);
            $movieAddress = strip_tags($input['address']);
            $response = Http::timeout(5)->get('https://data.sfgov.org/resource/yitu-d5am.json?', [
                '$$app_token' => env("SODA_API_KEY"),
                'title' => $movieName,
                'locations'=>  $movieAddress
            ]);
            $movies = json_encode($response->json());
            return response()->json(['movies'=>$movies]); 
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
