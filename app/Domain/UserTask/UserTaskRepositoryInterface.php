<?php

namespace App\Domain\UserTask;

use App\Domain\Shared\PagedResult;

/**
 * Interface UserTaskRepositoryInterface
 *
 * This interface defines the contract for user task repositories.
 */
interface UserTaskRepositoryInterface
{
    public function findByUser(int $userId): array | \Exception;
    
    public function create(UserTask $userTask): UserTask | \Exception;
    
    public function delete(int $id): bool | \Exception;

    public function searchByUser(
        int $userId,
        array $filters = [],
        int $page = 1,
        int $perPage = 15
    ): PagedResult;
}