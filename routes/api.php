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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

//Route::apiResource('causes', 'Api\CauseController');

//Route::middleware('auth:airlock')->group( function () {
    Route::apiResource('causes', 'Api\CauseController');
    Route::apiResource('skills', 'Api\SkillController');
    Route::apiResource('vacancies', 'Api\VacancyController');
    Route::apiResource('organizations', 'Api\OrganizationController');

//});
/*
Route::middleware('auth:airlock')->group( function () {
    Route::resource('causes', 'Api\CauseController');
});*/
