<?php

namespace App\Listeners;

use App\Events\UserAddedToTask;
use App\Mail\TaskAssignedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendUserAddedToTaskNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserAddedToTask $event): void
    {
        $task = $event->task;
        $user = $event->user;
        
        // Envoyer un email au nouvel utilisateur assigné
        Mail::to($user->email)->send(new TaskAssignedMail($task, $user));
    }
}
