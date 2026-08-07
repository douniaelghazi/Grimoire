<?php

namespace App\Listeners;

use App\Events\MemberAddedToProject;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Notifications\MemberAddedNotification;



class SendMemberAddedToProjectNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(MemberAddedToProject $event): void
{
    $event->member->notify(
        new MemberAddedNotification($event->project)
    );
}
}
