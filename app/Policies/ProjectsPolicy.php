<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Projects;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectsPolicy
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
        return $user->can('view_any_projects');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Projects $projects)
    {
        return $user->can('view_projects');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_projects');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Projects $projects)
    {
        return $user->can('update_projects');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Projects $projects)
    {
        return $user->can('delete_projects');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->can('delete_any_projects');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Projects $projects)
    {
        return $user->can('force_delete_projects');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user)
    {
        return $user->can('force_delete_any_projects');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Projects $projects)
    {
        return $user->can('restore_projects');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('restore_any_projects');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, Projects $projects)
    {
        return $user->can('replicate_projects');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user)
    {
        return $user->can('reorder_projects');
    }

}
