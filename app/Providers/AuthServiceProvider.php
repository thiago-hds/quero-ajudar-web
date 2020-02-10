<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\User::class            => \App\Policies\UserPolicy::class,
        \App\Organization::class    => \App\Policies\OrganizationPolicy::class,
        \App\Vacancy::class         => \App\Policies\VacancyPolicy::class,
        \App\Volunteer::class       => \App\Policies\VolunteerPolicy::class,
        \App\Enrollment::class       => \App\Policies\EnrollmentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
    }
}
