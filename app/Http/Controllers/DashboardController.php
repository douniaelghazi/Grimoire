<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $projects = $user->projects()
            ->with('users')
            ->get();

        $responsableProjects = $projects->filter(
            fn ($project) => $project->pivot->role === 'responsable'
        );

        $chercheurProjects = $projects->filter(
            fn ($project) => $project->pivot->role === 'chercheur'
        );

        $etudiantProjects = $projects->filter(
            fn ($project) => $project->pivot->role === 'etudiant_assistant'
        );

        return view('dashboard', compact(
            'projects',
            'responsableProjects',
            'chercheurProjects',
            'etudiantProjects'
        ));
    }
}