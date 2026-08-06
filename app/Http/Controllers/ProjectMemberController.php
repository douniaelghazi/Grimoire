<?php

namespace App\Http\Controllers;

use App\Events\MemberAddedToProject;
use App\Http\Requests\AddProjectMemberRequest;
use App\Models\Project;
use App\Models\User;

class ProjectMemberController extends Controller
{
    /**
     * Afficher le formulaire d'ajout d'un membre.
     */
    public function create(Project $project)
    {
        $availableUsers = User::whereDoesntHave('projects', function ($query) use ($project) {
            $query->where('projects.id', $project->id);
        })->get();

        return view('projects.add-member', compact('project', 'availableUsers'));
    }

    /**
     * Ajouter un membre au projet.
     */
    public function store(AddProjectMemberRequest $request, Project $project)
    {
        $project->users()->attach($request->user_id, [
            'role' => $request->role,
        ]);

        event(new MemberAddedToProject($project, User::findOrFail($request->user_id)));

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Membre ajouté avec succès.');
    }
}