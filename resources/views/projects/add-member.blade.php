@extends('layouts.app')

@section('title', 'Ajouter un membre')

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Ajouter un membre au projet</h1>
                <p class="text-sm text-gray-600">Projet : {{ $project->title }}</p>
            </div>
            <a href="{{ route('projects.show', $project) }}" class="rounded-md bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200">Retour</a>
        </div>

        @if($availableUsers->isEmpty())
            <div class="rounded-lg bg-yellow-50 p-4 text-sm text-yellow-800">Tous les utilisateurs font déjà partie de ce projet.</div>
        @endif

        <form action="{{ route('projects.members.store', $project) }}" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label for="user_id" class="block text-sm font-medium text-gray-700">Utilisateur</label>
                <select id="user_id" name="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Sélectionnez un utilisateur</option>
                    @foreach($availableUsers as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="responsable" {{ old('role') === 'responsable' ? 'selected' : '' }}>Responsable</option>
                    <option value="chercheur" {{ old('role') === 'chercheur' ? 'selected' : '' }}>Chercheur</option>
                    <option value="etudiant_assistant" {{ old('role') === 'etudiant_assistant' ? 'selected' : '' }}>Étudiant assistant</option>
                </select>
                @error('role')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="inline-flex justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Ajouter</button>
        </form>
    </div>
@endsection
