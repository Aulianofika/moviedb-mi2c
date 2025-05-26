<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [MovieController::class, 'homepage'])->name('homepage');
Route::get('/movie/{id}', [MovieController::class, 'show'])->name('movie.detail');
Route::get('/create-movie', [MovieController::class, 'create']);
Route::post('/movie-store', [MovieController::class, 'store']);
