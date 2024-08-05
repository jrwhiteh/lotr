<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RandomBoredIdea;
use App\Http\Controllers\wef;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/all-books', [wef::class, 'getAllBooks']);
Route::get('/filtered-books', [wef::class, 'getBookWithFilter']);

Route::get('/all-characters', [wef::class, 'getAllCharacters']);
Route::get('/filtered-characters', [wef::class, 'getCharacterWithFilter']);

Route::get('/all-movies', [wef::class, 'getAllMovies']);
Route::get('/filtered-movies', [wef::class, 'getMovieWithFilter']);

