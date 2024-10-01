<?php

namespace App\Providers;

use App\Interfaces\MemberInterface;
use App\repositories\MemberRepository;
use Illuminate\Support\ServiceProvider;

class MemberProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MemberInterface::class, MemberRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
