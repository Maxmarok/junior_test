<?php

use App\Http\Controllers\TracksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/v1')->as('api.')->group(function () {
    Route::post('get_music',[TracksController::class,'getMusic']);
    Route::post('add_music',[TracksController::class,'addTrack']);
    Route::get('music_list',[TracksController::class,'getTracksList']);
});

