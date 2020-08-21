<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth.basic.once'])->group(function () {
    Route::post('boards', 'BoardController@create');
    Route::put('boards/{id}', 'BoardController@update');
    Route::delete('boards/{id}', 'BoardController@delete');

    Route::get('tasks', 'TaskController@get');
    Route::post('tasks', 'TaskController@create');
    Route::post('tasks/{taskId}/labels/{labelId}', 'TaskController@attachLabel');
    Route::post('tasks/{taskId}/images', 'TaskController@attachImage');

    Route::post('labels', 'LabelsController@create');

    Route::get('logs', function () {
        return \App\Log::all();
    });
});

