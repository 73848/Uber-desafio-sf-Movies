<?php

namespace Tests\Feature;

use App\Http\Controllers\SFFilmesController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SFFilmesControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_json_format_are_returned_corretly(): void
    {
        $SfController = new SFFilmesController();
        $response = $SfController->getDataFromApi();

        $this->assertJson($response);
    }
}
