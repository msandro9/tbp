<?php

namespace App\Providers;

use App\Contracts\EmployeeRepositoryInterface;
use App\Contracts\TeamRepositoryInterface;
use App\Repositories\EmployeeRepository;
use App\Repositories\TeamRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(TeamRepositoryInterface::class, TeamRepository::class);
    }
}
