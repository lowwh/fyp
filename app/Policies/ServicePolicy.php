<?php

namespace App\Policies;

use App\Models\User;
use App\Models\service;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\service  $service
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, service $service)
    {
        return $user->id === $service->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    // public function create(User $user)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can update the model.
    //  *
    //  * @param  \App\Models\User  $user
    //  * @param  \App\Models\service  $service
    //  * @return \Illuminate\Auth\Access\Response|bool
    //  */
    public function update(User $user, service $service)
    {
        return $user->id === $service->user_id;
    }

    // /**
    //  * Determine whether the user can delete the model.
    //  *
    //  * @param  \App\Models\User  $user
    //  * @param  \App\Models\service  $service
    //  * @return \Illuminate\Auth\Access\Response|bool
    //  */
    public function delete(User $user, service $service)
    {
        return $user->id === $service->user_id;
    }

    // /**
    //  * Determine whether the user can restore the model.
    //  *
    //  * @param  \App\Models\User  $user
    //  * @param  \App\Models\service  $service
    //  * @return \Illuminate\Auth\Access\Response|bool
    //  */
    // public function restore(User $user, service $service)
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  *
    //  * @param  \App\Models\User  $user
    //  * @param  \App\Models\service  $service
    //  * @return \Illuminate\Auth\Access\Response|bool
    //  */
    // public function forceDelete(User $user, service $service)
    // {
    //     //
    // }
}
