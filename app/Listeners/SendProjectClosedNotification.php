<?php

namespace App\Listeners;

use App\Events\ProjectClosed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendProjectClosedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ProjectClosed $event): void
    {
        // Ajouter la logique de notification ou action ici.
    }
}
