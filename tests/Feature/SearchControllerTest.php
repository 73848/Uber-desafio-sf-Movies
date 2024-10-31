<?php

namespace Tests\Feature;

use App\Http\Controllers\SearchController;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
   // use RefreshDatabase;

    public function test_url_response_a_json(): void
    {
        $request = FacadesRequest::create('/search', 'GET', ['search'=>'Experiment in Terro']);
        $movieController = new SearchController();
        $response = $movieController->search($request);
        dump($response->getData()->movies);
        $this->assertJson($response->getData()->movies);
    }
}
