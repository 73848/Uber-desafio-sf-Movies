<?php

use App\Http\Controllers\SFFilmesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SFFilmesController::class, 'getDataFromApi']);
Route::get('/maps', function () {
    return view('welcome');
});