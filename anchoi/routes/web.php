<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\EntertainmentSpotController;
use App\Http\Controllers\Base;
use App\Models\EntertainmentSpot;

// Route::get('/provinces', [ProvinceController::class, 'index']);

Route::get('/', [EntertainmentSpotController::class, 'index']);
Route::get('/nearest/{type}',[EntertainmentSpotController::class,'findNearestEntertainmentSpotsByTypeRender']);
Route::get('/contact', [Base::class, 'contact']);
Route::get('/{params}/{id}', [EntertainmentSpotController::class, 'urlApiSearchDetailRender']);
Route::get('/{params}', [EntertainmentSpotController::class, 'urlApiSearchRender']);
Route::get('/hehe/hehe/hehe', [EntertainmentSpotController::class, 'index_nr']);

