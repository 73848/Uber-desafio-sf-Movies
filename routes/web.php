<?php

use App\Http\Controllers\SFFilmesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SFFilmesController::class, 'getingGeoLocationFromAdress']);
Route::get('/maps', function () {
    return view('welcome');
});