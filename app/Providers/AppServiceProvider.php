<?php

namespace App\Providers;

use App\Events\TaskCreated;
use App\Events\UserAddedToTask;
use App\Listeners\SendTaskCreatedNotification;
use App\Listeners\SendUserAddedToTaskNotification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Enregistrement des événements et listeners
        Event::listen(
            TaskCreated::class,
            SendTaskCreatedNotification::class
        );

        Event::listen(
            UserAddedToTask::class,
            SendUserAddedToTaskNotification::class
        );
    }
}
