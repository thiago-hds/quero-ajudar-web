<?php

namespace App\Policies;

use App\User;
use App\Vacancy;
use Illuminate\Auth\Access\HandlesAuthorization;

class VacancyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any vacancies.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the vacancy.
     *
     * @param  \App\User  $user
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function view(User $user, Vacancy $vacancy)
    {
        //
    }

    /**
     * Determine whether the user can create vacancies.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the vacancy.
     *
     * @param  \App\User  $user
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function update(User $user, Vacancy $vacancy)
    {
        //
    }

    /**
     * Determine whether the user can delete the vacancy.
     *
     * @param  \App\User  $user
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function delete(User $user, Vacancy $vacancy)
    {
        //
    }

    /**
     * Determine whether the user can restore the vacancy.
     *
     * @param  \App\User  $user
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function restore(User $user, Vacancy $vacancy)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the vacancy.
     *
     * @param  \App\User  $user
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function forceDelete(User $user, Vacancy $vacancy)
    {
        //
    }
}
