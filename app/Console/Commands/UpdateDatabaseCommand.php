<?php

namespace App\Console\Commands;

use App\Http\Controllers\SFFilmesController;
use App\Models\Movie;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movie:updateDatabase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to update the database with the data from the API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $controllerMovie = new SFFilmesController();

        $limit = 5;
        $response = Http::timeout(16)->get('https://data.sfgov.org/resource/yitu-d5am.json?', [
            '$limit'=>$limit ,
            '$$app_token'=>env("SODA_API_KEY"),
        ]);  
      for( $i=0; $i< $limit; $i++){
          $title = $response->json()[$i]['title'];
          $location = $response->json()[$i]['locations'];
          $geolocation = json_decode($controllerMovie->getingGeoLocationFromAdress($location));
          $data = [
              'title' => $title,
              'locations' => $location,
              'lat' => $geolocation->lat,
              'long' => $geolocation->lng
          ];
          Movie::create($data);

      }
      $this->info('Successfully updated database');

    }
}
