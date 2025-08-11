<?php

namespace App\Infrastructure\Eloquent\UserTask;

use App\Domain\Shared\PagedResult;
use App\Domain\UserTask\UserTask;
use App\Domain\UserTask\UserTaskRepositoryInterface;
use App\Infrastructure\Eloquent\UserTask\EloquentUserTaskModel;
use App\Infrastructure\Eloquent\UserTask\UserTaskMapper;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

/**
 * Eloquent implementation of the UserTaskRepositoryInterface.
 */
class EloquentUserTaskRepository implements UserTaskRepositoryInterface
{
    public function findByUser(int $userId): array | \Exception
    {
        $models = [];

        try {
            $models = EloquentUserTaskModel::where('user_id', $userId)->get();
        } catch (QueryException $e) {
            throw new \Exception("Failed to retrieve invitations for user ID {$userId}: " . $e->getMessage());
        }

        return $models
            ->map(fn ($model) => UserTaskMapper::toDomain($model))
            ->toArray();
    }

    public function create(UserTask $userTask): UserTask | \Exception
    {
        try {
            $model = EloquentUserTaskModel::create(UserTaskMapper::toPersistence($userTask));
        } catch (QueryException $e) {
            throw new \Exception("Failed to create user: " . $e->getMessage());
        }

        return UserTaskMapper::toDomain($model);
    }

    public function delete(int $id): bool | \Exception
    {
        try {

            return DB::transaction(function () use ($id) {
                $deleted = EloquentUserTaskModel::destroy($id) > 0;

                if (!$deleted) {
                    throw new \Exception("Task with ID {$id} not found");
                }

                return $deleted;
            });
            
        } catch (\Exception $e) {
            throw new \Exception("Failed to delete task: " . $e->getMessage());
        }
    }

    public function searchByUser(
        int $userId,
        array $filters = [],
        int $page = 1,
        int $perPage = 15
    ): PagedResult
    {
        $query = EloquentUserTaskModel::query()
            ->with('task')
            ->where('user_id', $userId)
            ->when(!empty($filters['search']), function ($q) use ($filters) {
                $q->whereHas('task', function ($q2) use ($filters) {
                    $q2->where('title', 'like', '%' . $filters['search'] . '%');
                });
            })
            ->when(!empty($filters['is_completed']), function ($q) use ($filters) {
                $q->where('is_completed', $filters['is_completed']);
            })
            ->orderBy($filters['sort_by'] ?? 'created_at', $filters['sort_dir'] ?? 'desc');

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);
        $done = $paginator->currentPage() >= $paginator->lastPage();

        return new PagedResult(
            $paginator->items(),
            $paginator->total(),
            $done,
            $page,
            $perPage
        );
    }
}