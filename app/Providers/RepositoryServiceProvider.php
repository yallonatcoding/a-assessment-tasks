<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Auth\UserPermissionValidatorInterface;
use App\Domain\Task\TaskRepositoryInterface;
use App\Domain\UserTask\UserTaskRepositoryInterface;
use App\Domain\User\UserRepositoryInterface;
use App\Domain\Invitation\InvitationRepositoryInterface;
use App\Infrastructure\Auth\DatabaseUserPermissionValidator;
use App\Infrastructure\Eloquent\Task\EloquentTaskRepository;
use App\Infrastructure\Eloquent\UserTask\EloquentUserTaskRepository;
use App\Infrastructure\Eloquent\User\EloquentUserRepository;
use App\Infrastructure\Eloquent\Invitation\EloquentInvitationRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            TaskRepositoryInterface::class,
            EloquentTaskRepository::class
        );

        $this->app->bind(
            UserTaskRepositoryInterface::class,
            EloquentUserTaskRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class
        );

        $this->app->bind(
            InvitationRepositoryInterface::class,
            EloquentInvitationRepository::class
        );

        $this->app->bind(
            UserPermissionValidatorInterface::class,
            DatabaseUserPermissionValidator::class
        );
    }
}
