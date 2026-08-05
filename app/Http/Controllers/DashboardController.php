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
            fn ($project) => $project->pivot->role === 'etudiantassistant'
        );

        return view('dashboard.index', compact(
            'projects',
            'responsableProjects',
            'chercheurProjects',
            'etudiantProjects'
        ));
    }
}