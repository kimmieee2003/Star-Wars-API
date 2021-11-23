<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Voor elke functie een nieuwe route naar de bijbehorende fuctie.

Route::get('/', [FilmController::class, 'index']);

Route::get('films', [FilmController::class, 'index']);

Route::get('film/{id}', [FilmController::class, 'film']);

Route::get('filmsearch/', [FilmController::class, 'filmsearch']);

Route::get('filmfavorites/', [FilmController::class, 'filmfavorites']);

Route::get('removefavorites/', [FilmController::class, 'removefavorites']);

Route::get('seeAllFavorites/', [filmController::class, 'seeAllFavorites']);

Route::get('removefavoritesfromfavorites/', [filmController::class, 'removefavoritesfromfavorites']);