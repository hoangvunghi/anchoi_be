<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\EntertainmentSpotController;

// Route::get('/provinces', [ProvinceController::class, 'index']);
Route::get('/', [EntertainmentSpotController::class, 'index']);