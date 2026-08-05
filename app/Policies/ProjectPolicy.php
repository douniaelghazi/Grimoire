<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    public function view(User $user, Project $project): Response
    {
        return $project->users()->where('user_id', $user->id)->exists()
            ? Response::allow()
            : Response::deny('Vous ne pouvez pas voir ce projet.');
    }

    public function create(User $user): Response
    {
        return Response::allow();
    }

    public function update(User $user, Project $project): Response
    {
        $role = $project->users()->where('user_id', $user->id)->value('role');

        if (in_array($role, ['responsable', 'chercheur'], true)) {
            return Response::allow();
        }

        return Response::deny('Vous ne pouvez pas modifier ce projet.');
    }

    public function delete(User $user, Project $project): Response
    {
        $role = $project->users()->where('user_id', $user->id)->value('role');

        if ($role !== 'responsable') {
            return Response::deny('Vous ne pouvez pas archiver ce projet.');
        }

        $responsableCount = $project->users()->wherePivot('role', 'responsable')->count();

        if ($responsableCount < 1) {
            return Response::deny('Le projet doit contenir au moins un responsable.');
        }

        return Response::allow();
    }

    public function addMember(User $user, Project $project): Response
    {
        return $project->users()->where('user_id', $user->id)->wherePivot('role', 'responsable')->exists()
            ? Response::allow()
            : Response::deny('Vous ne pouvez pas ajouter un membre à ce projet.');
    }

    public function removeMember(User $user, Project $project): Response
    {
        return $project->users()->where('user_id', $user->id)->wherePivot('role', 'responsable')->exists()
            ? Response::allow()
            : Response::deny('Vous ne pouvez pas retirer un membre de ce projet.');
    }
}
