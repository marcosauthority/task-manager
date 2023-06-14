<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group([
    'middleware' => ['api'],
], function ($router) {
    Route::resource('tasks', 'TaskController');
    Route::patch('tasks/{id}/completed', 'TaskController@completed');
    Route::get('overview', 'TaskController@overview');
    Route::resource('categories', 'CategoryController');
});


Route::post('login', 'AuthController@login')->middleware('api');

