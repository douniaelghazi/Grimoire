<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MemberAddedNotification extends Notification
{
    use Queueable;

    public function __construct(public Project $project)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Ajout à un projet')
            ->greeting('Bonjour '.$notifiable->name)
            ->line('Vous avez été ajouté au projet : '.$this->project->title)
            ->line('Rendez-vous sur Grimoire pour consulter le projet.')
            ->salutation('Merci');
    }
}