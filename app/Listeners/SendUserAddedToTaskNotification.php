<?php

namespace App\Listeners;

use App\Events\UserAddedToTask;
use App\Mail\TaskAssignedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendUserAddedToTaskNotification // implements ShouldQueue
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
        // dd('🎯 Listener handle() appelé !', $event->task->id, $event->user->email);
        
        Log::info('🎯 Listener déclenché automatiquement !', [
            'task_id' => $event->task->id,
            'user_email' => $event->user->email
        ]);

        $task = $event->task;
        $user = $event->user;
        
        // Envoyer un email au nouvel utilisateur assigné
        Mail::to($user->email)->send(new TaskAssignedMail($task, $user));
        
        Log::info('📧 Email envoyé avec succès !');
    }
}
