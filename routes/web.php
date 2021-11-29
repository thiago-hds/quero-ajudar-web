<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'Web\HomeController@index')->name('home');
Route::get('state/{abbr}/cities', 'Web\AddressController@getCitiesByStateAbbr');
Route::get('users/profile', 'Web\UserController@profile');

Route::resources([
    'users'         => 'Web\UserController',
    'organizations' => 'Web\OrganizationController',
    'vacancies'     => 'Web\VacancyController',
    'volunteers'    => 'Web\VolunteerController',
    'applications'   => 'Web\ApplicationController',
    'causes'        => 'Web\CauseController',
    'skills'        => 'Web\SkillController'
]);



Route::resource('applications', 'Web\ApplicationController')->except(['show', 'edit', 'update']);
