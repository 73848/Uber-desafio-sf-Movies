<?php

use App\Http\Controllers\SearchController;
use App\Http\Controllers\SFFilmesController;
use Illuminate\Support\Facades\Route;

Route::get('/locationOfMovies', [SFFilmesController::class, 'getDataFromApiWithLocalName']);
Route::get('/geolocation', [SFFilmesController::class, 'getingGeoLocationFromAdress']);
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/maps', function () {
    return view('welcome');
});