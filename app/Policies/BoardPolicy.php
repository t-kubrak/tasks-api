<?php

namespace App\Policies;

use App\Board;
use App\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoardPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Board  $board
     * @return mixed
     */
    public function view(User $user, Board $board)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Board  $board
     * @return mixed
     */
    public function update(User $user, Board $board)
    {
        return $user->id === $board->user_id
            ? Response::allow()
            : Response::deny('You do not own this board.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Board  $board
     * @return mixed
     */
    public function delete(User $user, Board $board)
    {
        return $user->id === $board->user_id
            ? Response::allow()
            : Response::deny('You do not own this board.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Board  $board
     * @return mixed
     */
    public function restore(User $user, Board $board)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Board  $board
     * @return mixed
     */
    public function forceDelete(User $user, Board $board)
    {
        //
    }
}
