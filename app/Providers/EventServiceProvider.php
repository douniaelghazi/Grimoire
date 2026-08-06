<?php

namespace App\Providers;

use App\Events\MemberAddedToProject;
use App\Events\ProjectClosed;
use App\Listeners\SendMemberAddedToProjectNotification;
use App\Listeners\SendProjectClosedNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        MemberAddedToProject::class => [
            SendMemberAddedToProjectNotification::class,
        ],
        ProjectClosed::class => [
            SendProjectClosedNotification::class,
        ],
    ];
}
