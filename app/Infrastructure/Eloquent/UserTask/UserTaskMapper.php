<?php

namespace App\Infrastructure\Eloquent\UserTask;

use App\Domain\UserTask\UserTask;
use App\Infrastructure\Eloquent\UserTask\EloquentUserTaskModel;

/**
 * Mapper class to convert between User domain objects and Eloquent models.
 */
class UserTaskMapper
{
    public static function toDomain(EloquentUserTaskModel $model): UserTask
    {
        return new UserTask(
            $model->id,
            $model->user_id,
            $model->task_id,
            \DateTimeImmutable::createFromMutable($model->created_at),
            \DateTimeImmutable::createFromMutable($model->updated_at)
        );
    }

    public static function toPersistence(UserTask $userTask): array
    {
        return [
            'user_id' => $userTask->userId(),
            'task_id' => $userTask->taskId(),
            'created_at' => $userTask->createdAt(),
            'updated_at' => $userTask->updatedAt(),
        ];
    }
}