<?php

namespace Tests\Feature;

use App\Http\Controllers\SFFilmesController;
use Tests\TestCase;

class SFFilmesControllerTest extends TestCase
{
    
  public function test_json_format_are_returned_on_geolocation_data_corretl(){
    $SfController = new SFFilmesController();
    $response = $SfController->getallDataFromApi(10);
    $this->assertJson($response);
}

    public function test_json_format_are_returned_on_geolocation_data_corretly(){
        $SfController = new SFFilmesController();
        $response = $SfController->getingGeoLocationFromAdress('100 St. Germain Avenue');
        $this->assertJson($response);
        dump($response);
    }
    public function test_json_structure_are_returned_on_movies_informations_corretly(){
        $this
        ->getJson(route('informations',['movie'=>'Chan is Missing']))
        ->assertOk()
        ->assertJsonStructure([
        'movies'=>[
            [
                'title',
                'release_year',
                'locations',
                'production_company',
                'distributor',
                'director',
                'writer',
                'actor_1',
                'actor_2',
                'actor_3',
            ]
        ]
    ]);
  }

   /*  public function test_structure_of_are_geted_corretly_response(){
        $response = $this->getJson('/');
        dump($response);
        $response->assertJsonStructure([
            'data' => [
              '0' => [
                'title',
                'release_year',
                'locations',
                'production_company',
                'distributor',
                'director',
                'writer',
                'actor_1',
                'actor_2',
                'actor_3',
                ':@computed_region_6qbp_sg9q',
                ':@computed_region_ajp5_b2md',
                ':@computed_region_26cr_cadq'
              ]
            ]
          ]); 
          
        }
        */
}
