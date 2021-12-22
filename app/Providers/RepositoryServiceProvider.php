<?php

namespace App\Providers;

use App\Repositories\ActivityBasicRepo;
use App\Repositories\ActivityTypeRepo;
use App\Repositories\Contract\ActivityBasicRepositoryInterface;
use App\Repositories\Contract\ActivityTypeRepositoryInterface;
use App\Repositories\Contract\RepositoryInterface;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ActivityTypeRepositoryInterface::class, ActivityTypeRepo::class);
        $this->app->bind(ActivityBasicRepositoryInterface::class, ActivityBasicRepo::class);
    }

    public function boot()
    {

    }
}
