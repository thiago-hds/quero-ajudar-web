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
        \App\Application::class      => \App\Policies\ApplicationPolicy::class,
        \App\Cause::class           => \App\Policies\CausePolicy::class,
        \App\Skill::class           => \App\Policies\SkillPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view-organizations', 'App\Policies\OrganizationPolicy@viewAny');
        Gate::define('view-volunteers', 'App\Policies\VolunteerPolicy@viewAny');
        Gate::define('create-applications', 'App\Policies\ApplicationPolicy@create');
        Gate::define('view-causes', 'App\Policies\CausePolicy@viewAny');
        Gate::define('view-skills', 'App\Policies\SkillPolicy@viewAny');
    }
}
