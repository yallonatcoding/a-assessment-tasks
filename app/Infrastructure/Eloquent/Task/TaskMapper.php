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
            $model->title,
            $model->description,
            $model->isCompleted,
            $model->created_at,
            $model->updated_at
        );
    }

    public static function toPersistence(Task $task): array
    {
        return [
            'title' => $task->title(),
            'description' => $task->description(),
            'isCompleted' => $task->isCompleted(),
            'created_at' => $task->createdAt(),
            'updated_at' => $task->updatedAt(),
        ];
    }
}
