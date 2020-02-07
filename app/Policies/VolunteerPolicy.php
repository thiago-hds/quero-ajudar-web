<?php

namespace App\Policies;

use App\User;
use App\Volunteer;
use Illuminate\Auth\Access\HandlesAuthorization;

class VolunteerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any volunteers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the volunteer.
     *
     * @param  \App\User  $user
     * @param  \App\Volunteer  $volunteer
     * @return mixed
     */
    public function view(User $user, Volunteer $volunteer)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create volunteers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the volunteer.
     *
     * @param  \App\User  $user
     * @param  \App\Volunteer  $volunteer
     * @return mixed
     */
    public function update(User $user, Volunteer $volunteer)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the volunteer.
     *
     * @param  \App\User  $user
     * @param  \App\Volunteer  $volunteer
     * @return mixed
     */
    public function delete(User $user, Volunteer $volunteer)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the volunteer.
     *
     * @param  \App\User  $user
     * @param  \App\Volunteer  $volunteer
     * @return mixed
     */
    public function restore(User $user, Volunteer $volunteer)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the volunteer.
     *
     * @param  \App\User  $user
     * @param  \App\Volunteer  $volunteer
     * @return mixed
     */
    public function forceDelete(User $user, Volunteer $volunteer)
    {
        return $user->isAdmin();
    }
}
