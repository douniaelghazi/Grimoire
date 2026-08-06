<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectMemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('verified')
        ->name('dashboard');

    // Gestion du profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Liste des projets archivés
    Route::get('/projects/archived', [ProjectController::class, 'archived'])
        ->name('projects.archived');

    // CRUD Projects
    Route::resource('projects', ProjectController::class);

    // Clôturer un projet
    Route::post('/projects/{project}/close', [ProjectController::class, 'close'])
        ->name('projects.close');

    // Gestion des membres
    Route::get('/projects/{project}/members/create', [ProjectMemberController::class, 'create'])
        ->name('projects.members.create');

    Route::post('/projects/{project}/members', [ProjectMemberController::class, 'store'])
        ->name('projects.members.store');

    Route::delete('/projects/{project}/members/{user}', [ProjectController::class, 'removeMember'])
        ->name('projects.members.destroy');
});

require __DIR__.'/auth.php';