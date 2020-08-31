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

Route::middleware('auth:sanctum')->group( function () {
    Route::post('causes/update-user-causes', 'Api\CauseController@updateUserCauses');
    Route::post('skills/update-user-skills', 'Api\SkillController@updateUserSkills');

    Route::apiResource('causes', 'Api\CauseController');
    Route::apiResource('skills', 'Api\SkillController');
    Route::apiResource('vacancies', 'Api\VacancyController');
    Route::apiResource('organizations', 'Api\OrganizationController');
    Route::apiResource('enrollment', 'Api\EnrollmentController');

    //Favorites routes
    Route::post('favorites/vacancies/{vacancy}/favorite', 'Api\FavoritesController@saveVacancyAsFavorite');
    Route::post('favorites/organizations/{organization}/favorite', 'Api\FavoritesController@saveOrganizationAsFavorite');
    Route::get('favorites/vacancies', 'Api\FavoritesController@favoriteVacancies');
    Route::get('favorites/organizations', 'Api\FavoritesController@favoriteOrganizations');
    
    //Profile routes
    Route::get('profile', 'Api\VolunteerProfileController@getUserProfile');


});