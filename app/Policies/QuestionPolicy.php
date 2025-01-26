<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuestionPolicy
{

    public function before(User $user, $ability)
    {
        if ($user->hasRole('admin')) {
            return true; // Admins can bypass all checks
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Question $question): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Question $question): bool
    {
        return $user->can('edit') || $user->hasRole('editor');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Question $question): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Question $question): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Question $question): bool
    {
        return false;
    }
}
