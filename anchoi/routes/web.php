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
use App\Http\Controllers\BlogController;
Route :: get ('/blog', [BlogController :: class, 'indexRender']);
Route :: get ('/blog/{slug}', [BlogController :: class, 'getBlogBySlugRender']);
Route::get('/', [EntertainmentSpotController::class, 'index']);
Route::get('/nearest/{type}',[EntertainmentSpotController::class,'findNearestEntertainmentSpotsByTypeRender']);
Route::get('/nearest',[EntertainmentSpotController::class,'findNearestEntertainmentSpotsRender']);
Route::get('/contact', [Base::class, 'contact']);
Route::get('/{params}/{id}', [EntertainmentSpotController::class, 'urlApiSearchDetailRender']);
Route::get('/{params}', [EntertainmentSpotController::class, 'urlApiSearchRender']);
// Route::get('/hehe/hehe/hehe', [EntertainmentSpotController::class, 'index_nr']);
Route::get('/list/cac-dia-diem/vui-choi', [EntertainmentSpotController::class, 'index_all']);
Route::get('/list/cac-dia-diem/an-uong', [EntertainmentSpotController::class, 'index_an']);
Route::get('/list/cac-dia-diem/choi', [EntertainmentSpotController::class, 'index_choi']);
Route::post('/save-location', [EntertainmentSpotController::class, 'saveLocation']);
use App\Http\Controllers\CommentController;

Route::prefix('/api/comments')->group(function () {
    Route::post('', [CommentController::class, 'store']);
    Route::get('/{id}', [CommentController::class, 'showWithReplies']);
});


Route::prefix('api/v1/provinces')->group(function () {
    Route::get('', [ProvinceController::class, 'index']);
    Route::get('/{id}', [ProvinceController::class, 'show']);
});

use App\Http\Controllers\DistrictController;

Route::prefix('api/v1/districts')->group(function () {
    Route::get('/province/{id}', [DistrictController::class, 'getDistrictByProvince']);
    Route::get('/{id}', [DistrictController::class, 'show']);
});

use App\Http\Controllers\WardController;

Route::prefix('api/v1/wards')->group(function () {
    Route::get('/district/{id}', [WardController::class, 'getWardByDistrict']);
    Route::get('/{id}', [WardController::class, 'show']);
});

use App\Http\Controllers\EntertainmentTypeController;

Route :: prefix ('api/v1/entertainment-types') -> group (function () {
    Route :: get ('', [EntertainmentTypeController :: class, 'index']);
    Route :: get ('/{id}', [EntertainmentTypeController :: class, 'show']);
});



// Route :: prefix ('blog/blog/blog') -> group (function () {
//     Route :: get ('', [BlogController :: class, 'indexRender']);
//     // Route :: get ('/{id}', [BlogController :: class, 'show']);
// });