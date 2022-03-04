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

use App\Http\Controllers\Auth\LoginController;
use App\Vacancy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $vacancies = \App\Vacancy::latest()->limit(6)->get();
    return view('website.home', compact('vacancies'));
});

Route::get('/login', function () {
    return view('website.login');
})->name('website.login');

Route::post('/login', [LoginController::class, 'login']);


Route::get('/profile', function () {
    return view('website.profile');
});

Route::get('/vacancy/{vacancy}', function (Vacancy $vacancy) {
    return view('website.vacancy_details')->with([
        'vacancy' => $vacancy
    ]);
})->name('website.vacancy_details');

Route::get('/admin', function () {
    return redirect('/admin/login');
});


Route::get('state/{abbr}/cities', 'Web\AddressController@getCitiesByStateAbbr');
Route::prefix('admin')->group(function () {

    Auth::routes();

    Route::get('/dashboard', 'Web\HomeController@index')->name('dashboard');
    Route::get('users/profile', 'Web\UserController@profile');

    Route::resources([
        'users'         => 'Web\UserController',
        'organizations' => 'Web\OrganizationController',
        'vacancies'     => 'Web\VacancyController',
        'volunteers'    => 'Web\VolunteerController',
        'applications'  => 'Web\ApplicationController',
        'causes'        => 'Web\CauseController',
        'skills'        => 'Web\SkillController'
    ]);

    Route::resource('applications', 'Web\ApplicationController')->except([
        'show', 'edit', 'update'
    ]);
});
