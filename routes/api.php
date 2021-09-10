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
Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::middleware('auth:sanctum')->group( function () {
    Route::post('causes/update-user-causes', 'Api\CauseController@updateUserCauses');
    Route::post('skills/update-user-skills', 'Api\SkillController@updateUserSkills');
    Route::get('vacancies/recommendations', 'Api\VacancyController@vacancyRecommendations');

    Route::apiResource('causes', 'Api\CauseController',  array("as" => "api"));
    Route::apiResource('skills', 'Api\SkillController',  array("as" => "api"));
    Route::apiResource('vacancies', 'Api\VacancyController', array("as" => "api"));
    Route::apiResource('organizations', 'Api\OrganizationController',  array("as" => "api"));
    Route::apiResource('applications', 'Api\ApplicationController',  array("as" => "api"));

    //Favorites routes
    Route::post(
        'favorites/vacancies/{vacancy}/favorite',
        'Api\FavoritesController@saveVacancyAsFavorite'
    );
    Route::post(
        'favorites/organizations/{organization}/favorite',
         'Api\FavoritesController@saveOrganizationAsFavorite'
    );
    Route::get('favorites/vacancies', 'Api\FavoritesController@favoriteVacancies');
    Route::get('favorites/organizations', 'Api\FavoritesController@favoriteOrganizations');

    //Profile routes
    Route::get('profile', 'Api\VolunteerProfileController@getUserProfile');
    Route::post('profile/edit', 'Api\VolunteerProfileController@editUserProfile');

});
