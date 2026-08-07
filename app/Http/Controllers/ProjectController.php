<?php

namespace App\Http\Controllers;

use App\Events\ProjectClosed;
use App\Http\Requests\AddProjectMemberRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\User;
use App\Events\MemberAddedToProject;



class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = auth()->user()
            ->projects()
            ->with('users')
            ->get();

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Project::class);

        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $this->authorize('create', Project::class);

        $project = Project::create($request->validated());
        $project->users()->attach(auth()->id(), ['role' => 'responsable']);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Projet créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        $project->load('users');

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        $project->load('users');

        $isResearcherOnly = $project->users()
            ->where('user_id', auth()->id())
            ->wherePivot('role', 'chercheur')
            ->exists();

        return view('projects.edit', compact('project', 'isResearcherOnly'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $role = $project->users()
            ->where('user_id', auth()->id())
            ->value('role');

        if ($role === 'chercheur') {
            $validated = $request->validate([
                'avancement' => 'required|integer|min:0|max:100',
            ]);
        } else {
            $validated = $request->validated();
        }

        $project->update($validated);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Projet mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Projet archivé avec succès.');
    }

    public function archived()
    {
        $projects = auth()->user()
            ->projects()
            ->onlyTrashed()
            ->with('users')
            ->get();

        return view('projects.archived', compact('projects'));
    }

    public function createMember(Project $project)
    {
        $this->authorize('addMember', $project);

        $project->load('users');

        $memberIds = $project->users->pluck('id')->all();
        $availableUsers = User::whereNotIn('id', $memberIds)->get();

        return view('projects.add-member', compact('project', 'availableUsers'));
    }

   public function addMember(AddProjectMemberRequest $request, Project $project)
{
    $this->authorize('addMember', $project);

    $user = User::findOrFail($request->user_id);

    $project->users()->syncWithoutDetaching([
        $user->id => [
            'role' => $request->role,
        ],
    ]);

    event(new MemberAddedToProject($project, $user));

    return redirect()
        ->route('projects.show', $project)
        ->with('success', 'Membre ajouté avec succès.');
}

    public function removeMember(Project $project, User $user)
    {
        $this->authorize('removeMember', $project);

        if (! $project->users()->where('user_id', $user->id)->exists()) {
            return redirect()
                ->route('projects.show', $project)
                ->with('error', 'Utilisateur non trouvé dans le projet.');
        }

        $memberRole = $project->users()
            ->where('user_id', $user->id)
            ->value('role');

        $responsableCount = $project->users()
            ->wherePivot('role', 'responsable')
            ->count();

        if ($memberRole === 'responsable' && $responsableCount <= 1) {
            return redirect()
                ->route('projects.show', $project)
                ->with('error', 'Impossible de retirer le dernier responsable.');
        }

        $project->users()->detach($user->id);

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Membre retiré avec succès.');
    }

    /**
     * Close the project.
     */
    public function close(Project $project)
{
    $this->authorize('update', $project);

    $project->update([
        'status' => 'cloture'
    ]);

    event(new ProjectClosed($project));

    return redirect()
        ->route('projects.index')
        ->with('success', 'Projet clôturé avec succès.');
}
}
