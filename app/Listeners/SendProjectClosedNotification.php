<?php

namespace App\Listeners;

use App\Events\ProjectClosed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class SendProjectClosedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ProjectClosed $event): void
    {
        $project = $event->project;

        $content = "
==============================
RAPPORT DE CLÔTURE
==============================

Projet : {$project->title}

Description :
{$project->description}

Statut : {$project->status}

Avancement : {$project->avancement} %

Date de clôture : " . now() . "

==============================
";

        Storage::disk('local')->put(
            "reports/project-{$project->id}.txt",
            $content
        );
    }
}