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
        $limit = 500;
        $response = json_decode($controllerMovie->getallDataFromApi($limit));
        $response = json_decode($response->movies);
        foreach ($response as $response) {
            if(property_exists($response, 'locations')){
                $geolocation = json_decode($controllerMovie->getingGeoLocationFromAdress($response->locations));
                $data = [
                    'title' => $response->title,
                    'locations' => $response->locations,
                    'lat' => $geolocation->lat,
                    'long' => $geolocation->lng,
                ];
                Movie::create($data);
            }
        }
        $this->info('Successfully updated database');
    }
}
