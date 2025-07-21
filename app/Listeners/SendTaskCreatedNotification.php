<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use App\Mail\NewTaskCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendTaskCreatedNotification implements ShouldQueue
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
    public function handle(TaskCreated $event): void
    {
        $task = $event->task;
        
        // Charger les utilisateurs assignés à la tâche
        $task->load('users');
        
        // Envoyer un email à chaque utilisateur assigné
        foreach ($task->users as $user) {
            Mail::to($user->email)->send(new NewTaskCreatedMail($task, $user));
        }
    }
}
