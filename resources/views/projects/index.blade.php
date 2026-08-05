@extends('layouts.app')

@section('title', 'Liste des projets')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Mes projets</h1>
                <p class="text-sm text-gray-600">Liste des projets auxquels vous participez.</p>
            </div>

            @can('create', App\Models\Project::class)
                <a href="{{ route('projects.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Créer un projet</a>
            @endcan
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-50 p-4 text-sm text-green-700">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-700">{{ session('error') }}</div>
        @endif

        @if($projects->isEmpty())
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <p class="text-sm text-gray-600">Vous n'êtes membre d'aucun projet pour le moment.</p>
            </div>
        @else
            <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Titre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Avancement</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Mon rôle</th>
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($projects as $project)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $project->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($project->status) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $project->avancement }} %</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $project->users->firstWhere('id', auth()->id())?->pivot->role ?? '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-900">Voir</a>

                                    @can('update', $project)
                                        <a href="{{ route('projects.edit', $project) }}" class="text-gray-600 hover:text-gray-900">Modifier</a>
                                    @endcan

                                    @can('delete', $project)
                                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Voulez-vous vraiment archiver ce projet ?')">Archiver</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('projects.archived') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Voir les projets archivés</a>
        </div>
    </div>
@endsection