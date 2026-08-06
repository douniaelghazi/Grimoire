<?php

namespace App\Listeners;

use App\Events\MemberAddedToProject;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMemberAddedToProjectNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(MemberAddedToProject $event): void
    {
        // Ajouter la logique de notification ou action ici.
    }
}
