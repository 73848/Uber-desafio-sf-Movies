<?php

use App\Http\Controllers\SearchController;
use App\Http\Controllers\SFFilmesController;
use Illuminate\Support\Facades\Route;

Route::get('/locationOfMovies', [SFFilmesController::class, 'getDataFromApiWithLocalName']);
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/movies', [SFFilmesController::class, 'getAllMovies'])->name('movies');
Route::get('/maps', function () {
    return view('welcome');
});