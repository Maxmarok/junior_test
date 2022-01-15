<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/{request}', 'HomeController@index')->where('request', 'music')->name('main');

Route::prefix('/api/v1')->as('api.')->group(function () {
    Route::post('get_music', [MusicsController::class, 'getMusic']);
    Route::post('add_music', [MusicsController::class, 'addMusic']);
    Route::get('music_list', [MusicsController::class, 'music_list']);
});
