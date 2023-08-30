<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\RepositoryInterface;
use App\Repositories\Repository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(RepositoryInterface::class, Repository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
