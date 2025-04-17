<?php

namespace App\Providers;

use Illuminate\Mail\MailManager;
use Illuminate\Mail\Transport\ResendTransport;
use Illuminate\Support\ServiceProvider;
use Resend;

class ResendServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        app(MailManager::class)->extend('resend', function ($config) {
            $client = Resend::client(config('mail.resend.api_key'));

            return new ResendTransport($client);
        });
    }
}
