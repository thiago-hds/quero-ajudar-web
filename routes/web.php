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

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('state/{abbr}/cities', 'AddressController@getCitiesByStateAbbr');

Route::resource('users', 'UserController');
Route::resource('organizations', 'OrganizationController');
Route::resource('vacancies', 'VacancyController');
Route::resource('volunteers', 'VolunteerController');