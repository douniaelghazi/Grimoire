<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    // Gestion du profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD Projects
    Route::resource('projects', ProjectController::class);

    Route::get('/projects/archived', [ProjectController::class, 'archived'])
        ->name('projects.archived');

    Route::get('/projects/{project}/members/create', [ProjectController::class, 'createMember'])
        ->name('projects.members.create');

    Route::post('/projects/{project}/members', [ProjectController::class, 'addMember'])
        ->name('projects.members.store');

    Route::delete('/projects/{project}/members/{user}', [ProjectController::class, 'removeMember'])
        ->name('projects.members.destroy');

    // Clôturer un projet
    Route::post('/projects/{project}/close', [ProjectController::class, 'close'])
        ->name('projects.close');
});

require __DIR__.'/auth.php';