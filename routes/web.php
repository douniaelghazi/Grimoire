<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::view('/dashboard', 'dashboard.index');
Route::view('/projects', 'projects.index');
Route::view('/projects/create', 'projects.create');
Route::view('/projects/edit', 'projects.edit');
Route::view('/projects/show', 'projects.show');