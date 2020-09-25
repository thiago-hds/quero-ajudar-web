<?php

namespace App\Policies;

use App\Application;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any applications.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return !$user->isVolunteer();
    }

    /**
     * Determine whether the user can view the application.
     *
     * @param  \App\User  $user
     * @param  \App\Application  $application
     * @return mixed
     */
    public function view(User $user, Application $application)
    {
        return $user->isAdmin() || $user->organization_id === $application->vacancy->organization_id;
    }

    /**
     * Determine whether the user can create applications.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the application.
     *
     * @param  \App\User  $user
     * @param  \App\Application  $application
     * @return mixed
     */
    public function update(User $user, Application $application)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the application.
     *
     * @param  \App\User  $user
     * @param  \App\Application  $application
     * @return mixed
     */
    public function delete(User $user, Application $application)
    {
        $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the application.
     *
     * @param  \App\User  $user
     * @param  \App\Application  $application
     * @return mixed
     */
    public function restore(User $user, Application $application)
    {
        $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the application.
     *
     * @param  \App\User  $user
     * @param  \App\Application  $application
     * @return mixed
     */
    public function forceDelete(User $user, Application $application)
    {
        $user->isAdmin();
    }
}
