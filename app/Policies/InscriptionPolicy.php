<?php

namespace App\Policies;

use App\Models\Formation;
use App\Models\Inscription;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InscriptionPolicy
{
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
    public function view(User $user, Inscription $inscription): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Formation $formation): bool | string
    {
        if (!$user->hasRole('apprenant')) {
            return 'Seul un apprenant peut s\'inscrire à une formation';
        }

        if ($user->isAdminOf($formation->centre_id)) {
            return 'Un admin ne peut pas s\'inscrire à une formation de son propre centre';
        }

        $dejaInscrit = Inscription::where('user_id', $user->id)
            ->where('formation_id', $formation->id)
            ->exists();

        if ($dejaInscrit) {
            return 'Vous êtes déjà inscrit à cette formation';
        }

        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Inscription $inscription): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Inscription $inscription): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Inscription $inscription): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Inscription $inscription): bool
    {
        return false;
    }
}
