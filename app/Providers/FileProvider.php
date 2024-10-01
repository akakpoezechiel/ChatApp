<?php

namespace App\Providers;

use App\Interfaces\FileInterface;
use App\Repositories\FileRepository;
// use App\Repositories\Interfaces\FileInterface;
use Illuminate\Support\ServiceProvider;

class FileProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(FileInterface::class, FileRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
