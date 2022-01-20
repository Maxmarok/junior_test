<?php

use App\Http\Controllers\Api\MusicController;
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
    Route::post('/add_music', [MusicController::class, 'add']);
    Route::post('/get_music', [MusicController::class, 'get']);
    Route::get('/music_list', [MusicController::class, 'getList']);
});
