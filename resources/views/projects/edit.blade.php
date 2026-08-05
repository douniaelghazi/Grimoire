@extends('layouts.app')

@section('title', 'Modifier un projet')

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Modifier le projet</h1>
            <p class="text-sm text-gray-600">Mettez à jour les informations du projet.</p>
        </div>

        <form action="{{ route('projects.update', $project) }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow-sm">
            @csrf
            @method('PUT')

            @include('projects._form')

            <div class="flex justify-end gap-2">
                <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center rounded-md bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200">Annuler</a>
                <button type="submit" class="inline-flex justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Enregistrer</button>
            </div>
        </form>
    </div>
@endsection