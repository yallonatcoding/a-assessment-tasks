<?php

namespace App\Infrastructure\Eloquent\Task;

use App\Domain\Task\Task;
use App\Domain\Task\TaskRepositoryInterface;
use App\Infrastructure\Eloquent\Task\EloquentTaskModel;
use App\Infrastructure\Eloquent\Task\TaskMapper;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

/**
 * Eloquent implementation of the TaskRepositoryInterface.
 */
class EloquentTaskRepository implements TaskRepositoryInterface
{
    public function all(): array | \Exception
    {
        $models = [];

        try {
            $models = EloquentTaskModel::all();
        } catch (QueryException $e) {
            throw new \Exception("Failed to retrieve tasks: " . $e->getMessage());
        }

        return $models
            ->map(fn ($model) => TaskMapper::toDomain($model))
            ->toArray();
    }

    public function find(int $id): Task | \Exception
    {
        $model = null;

        try {
            $model = EloquentTaskModel::findOrFail($id);
        } catch (ModelNotFoundException) {
            throw new \Exception("Task with ID {$id} not found");
        }

        return TaskMapper::toDomain($model);
    }

    public function create(Task $task): Task | \Exception
    {
        try {
            $model = EloquentTaskModel::create(TaskMapper::toPersistence($task));
        } catch (QueryException $e) {
            throw new \Exception("Failed to create task: " . $e->getMessage());
        }

        return TaskMapper::toDomain($model);
    }

    public function update(Task $task): Task | \Exception
    {
        $updatedTask = null;

        try {
            $updatedTask = DB::transaction(function () use ($task) {
                $model = EloquentTaskModel::findOrFail($task->id());

                $model->update(TaskMapper::toPersistence($task));

                return TaskMapper::toDomain($model);
            });
        } catch (ModelNotFoundException) {
            throw new \Exception("Task with ID {$task->id()} not found");
        } catch (\Exception $e) {
            throw new \Exception("Failed to update task: " . $e->getMessage());
        }

        return $updatedTask;
    }

    public function delete(int $id): bool | \Exception
    {
        try {

            return DB::transaction(function () use ($id) {
                $deleted = EloquentTaskModel::destroy($id) > 0;

                if (!$deleted) {
                    throw new \Exception("Task with ID {$id} not found");
                }

                return $deleted;
            });
            
        } catch (\Exception $e) {
            throw new \Exception("Failed to delete task: " . $e->getMessage());
        }
    }
}
