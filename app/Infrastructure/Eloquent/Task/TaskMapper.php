<?php

namespace App\Infrastructure\Eloquent\Task;

use App\Domain\Task\Task;
use App\Infrastructure\Eloquent\Task\EloquentTaskModel;

/**
 * Mapper class to convert between Task domain objects and Eloquent models.
 */
class TaskMapper
{
    public static function toDomain(EloquentTaskModel $model): Task
    {
        return new Task(
            $model->id,
            $model->user_id,
            $model->title,
            $model->description,
            $model->is_completed,
            \DateTimeImmutable::createFromMutable($model->created_at),
            \DateTimeImmutable::createFromMutable($model->updated_at)
        );
    }

    public static function toPersistence(Task $task): array
    {
        return [
            'user_id' => $task->userId(),
            'title' => $task->title(),
            'description' => $task->description(),
            'is_completed' => $task->isCompleted(),
            'created_at' => $task->createdAt(),
            'updated_at' => $task->updatedAt(),
        ];
    }
}
