@extends('layouts.app')

@section('title', 'Créer un projet')

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Créer un projet</h1>
            <p class="text-sm text-gray-600">Remplissez les informations du projet.</p>
        </div>

        <form action="{{ route('projects.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow-sm">
            @csrf

            @include('projects._form')

            <div class="flex justify-end">
                <button type="submit" class="inline-flex justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Créer</button>
            </div>
        </form>
    </div>
@endsection