<?php

use App\Http\Controllers\SFFilmesController;
use Illuminate\Support\Facades\Route;

Route::get('/locationOfMovies', [SFFilmesController::class, 'getDataFromApi']);
Route::get('/geolocation', [SFFilmesController::class, 'getingGeoLocationFromAdress']);
Route::get('/maps', function () {
    return view('welcome');
});