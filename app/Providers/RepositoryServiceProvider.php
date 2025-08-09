<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Task\TaskRepositoryInterface;
use App\Infrastructure\Eloquent\Task\EloquentTaskRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
			TaskRepositoryInterface::class,
			EloquentTaskRepository::class
		);
    }
}
