<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('user', 'UserController@get');
Route::get('user/{id}', 'UserController@get');
Route::post('user', 'UserController@create');
Route::post('user/login', 'UserController@login');
Route::put('user/{id}', 'UserController@update');
Route::delete('user/{id}', 'UserController@delete');

Route::get('{userId}/project', 'ProjectController@get');
Route::get('{userId}/project/{id}', 'ProjectController@get');
Route::post('{userId}/project', 'ProjectController@create');
Route::put('project/{id}', 'ProjectController@update');
Route::delete('project/{id}', 'ProjectController@delete');

Route::get('{userId}/project/{projectId}/register', 'RegisterController@get');
Route::get('{userId}/project/{projectId}/register/{id}', 'RegisterController@get');
Route::post('{userId}/project/{projectId}/register', 'RegisterController@create');
Route::post('register/{id}', 'RegisterController@finish');
Route::put('register/{id}', 'RegisterController@update');
Route::delete('register/{id}', 'RegisterController@delete');