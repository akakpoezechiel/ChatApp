<?php

namespace App\Providers;

use App\Interfaces\GroupeInterface;
use App\Repositories\GroupeRepository;
use Illuminate\Support\ServiceProvider;

class GroupeProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(GroupeInterface::class, GroupeRepository::class);
    }

    

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
