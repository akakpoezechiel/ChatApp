<?php

namespace App\Providers;

use App\Interfaces\MessageInterface;
use App\Repositories\MessageRepository;
use Illuminate\Support\ServiceProvider;

class MessageProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MessageInterface::class, MessageRepository::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
