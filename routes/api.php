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

Route::post('boards', 'BoardController@create');
Route::put('boards/{id}', 'BoardController@update');

Route::post('tasks', 'TaskController@create');
Route::post('tasks/{taskId}/labels/{labelId}', 'TaskController@attachLabel');

Route::post('labels', 'LabelsController@create');
