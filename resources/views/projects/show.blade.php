@extends('layouts.app')

@section('title', 'Détails du projet')

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">{{ $project->title }}</h1>
                <p class="text-sm text-gray-600">{{ $project->description }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                @can('addMember', $project)
                    <a href="{{ route('projects.members.create', $project) }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Ajouter membre</a>
                @endcan
                @can('update', $project)
    <a href="{{ route('projects.edit', $project) }}"
       class="inline-flex items-center rounded-md bg-gray-600 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">
        Modifier
    </a>

    @if($project->status === 'encours')
        <form action="{{ route('projects.close', $project) }}" method="POST" class="inline">
            @csrf
            <button type="submit"
                    class="inline-flex items-center rounded-md bg-yellow-500 px-4 py-2 text-sm font-medium text-white hover:bg-yellow-600"
                    onclick="return confirm('Voulez-vous clôturer ce projet ?')">
                Clôturer
            </button>
        </form>
    @else
        <span class="inline-flex items-center rounded-md bg-green-100 px-4 py-2 text-sm font-medium text-green-700">
            Projet clôturé
        </span>
    @endif
@endcan
                @can('delete', $project)
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700" onclick="return confirm('Voulez-vous vraiment archiver ce projet ?')">Archiver</button>
                    </form>
                @endcan
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">Informations</h2>
                <dl class="mt-4 space-y-4 text-sm text-gray-600">
                    <div>
                        <dt class="font-medium text-gray-900">Statut</dt>
                        <dd>{{ ucfirst($project->status) }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-900">Avancement</dt>
                        <dd>{{ $project->avancement }} %</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-900">Membres</dt>
                        <dd>{{ $project->users->count() }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">Équipe</h2>
                <div class="mt-4 space-y-4">
                    @foreach($project->users as $member)
                        <div class="flex items-center justify-between rounded-lg border border-gray-200 px-4 py-3">
                            <div>
                                <p class="font-medium text-gray-900">{{ $member->name }}</p>
                                <p class="text-sm text-gray-500">{{ $member->email }} · {{ ucfirst($member->pivot->role) }}</p>
                            </div>
                            @can('removeMember', $project)
                                @if($member->id !== auth()->id())
                                    <form action="{{ route('projects.members.destroy', ['project' => $project, 'user' => $member]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-900" onclick="return confirm('Retirer ce membre ?')">Retirer</button>
                                    </form>
                                @endif
                            @endcan
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('projects.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Retour à la liste</a>
        </div>
    </div>
@endsection