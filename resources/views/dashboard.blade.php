@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="max-w-7xl mx-auto py-8 px-4">

    <h1 class="text-3xl font-bold text-gray-900 mb-2">
        Dashboard
    </h1>

    <p class="text-gray-600 mb-8">
        Bienvenue {{ auth()->user()->name }}
    </p>


    {{-- RESPONSABLE --}}
    @if($responsableProjects->isNotEmpty())

        <div class="mb-10">

            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
                Dashboard Responsable
            </h2>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

                @foreach($responsableProjects as $project)

                    <div class="bg-white rounded-lg shadow p-6">

                        <h3 class="text-lg font-semibold">
                            {{ $project->title }}
                        </h3>

                        <p class="text-sm text-gray-600 mt-2">
                            {{ $project->description }}
                        </p>

                        <p class="mt-3 text-sm">
                            Avancement :
                            <strong>{{ $project->avancement }}%</strong>
                        </p>

                        @can('update', $project)
                            <a
                                href="{{ route('projects.edit', $project) }}"
                                class="inline-block mt-4 text-indigo-600"
                            >
                                Modifier
                            </a>
                        @endcan

                        @can('addMember', $project)
                            <a
                                href="{{ route('projects.members.create', $project) }}"
                                class="inline-block mt-4 ml-3 text-indigo-600"
                            >
                                Ajouter membre
                            </a>
                        @endcan

                    </div>

                @endforeach

            </div>

        </div>

    @endif


    {{-- CHERCHEUR --}}
    @if($chercheurProjects->isNotEmpty())

        <div class="mb-10">

            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
                Dashboard Chercheur
            </h2>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

                @foreach($chercheurProjects as $project)

                    <div class="bg-white rounded-lg shadow p-6">

                        <h3 class="text-lg font-semibold">
                            {{ $project->title }}
                        </h3>

                        <p class="text-sm text-gray-600 mt-2">
                            {{ $project->description }}
                        </p>

                        <p class="mt-3 text-sm">
                            Avancement :
                            <strong>{{ $project->avancement }}%</strong>
                        </p>

                        @can('update', $project)
                            <a
                                href="{{ route('projects.edit', $project) }}"
                                class="inline-block mt-4 text-indigo-600"
                            >
                                Mettre à jour l'avancement
                            </a>
                        @endcan

                    </div>

                @endforeach

            </div>

        </div>

    @endif


    {{-- ETUDIANT ASSISTANT --}}
    @if($etudiantProjects->isNotEmpty())

        <div class="mb-10">

            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
                Dashboard Étudiant
            </h2>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

                @foreach($etudiantProjects as $project)

                    <div class="bg-white rounded-lg shadow p-6">

                        <h3 class="text-lg font-semibold">
                            {{ $project->title }}
                        </h3>

                        <p class="text-sm text-gray-600 mt-2">
                            {{ $project->description }}
                        </p>

                        <p class="mt-3 text-sm">
                            Avancement :
                            <strong>{{ $project->avancement }}%</strong>
                        </p>

                        <a
                            href="{{ route('projects.show', $project) }}"
                            class="inline-block mt-4 text-indigo-600"
                        >
                            Voir le projet
                        </a>

                    </div>

                @endforeach

            </div>

        </div>

    @endif


    @if($projects->isEmpty())

        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600">
                Vous n'avez aucun projet pour le moment.
            </p>
        </div>

    @endif

</div>

@endsection