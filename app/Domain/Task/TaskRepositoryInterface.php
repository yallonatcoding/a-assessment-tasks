<?php

namespace App\Domain\Task;

use App\Domain\Shared\PagedResult;
use App\Domain\Task\Task;

/**
 * Interface TaskRepositoryInterface
 *
 * Defines the contract for a Task repository.
 */
interface TaskRepositoryInterface
{
    public function all(): array | \Exception;
    
    public function find(int $id): Task | \Exception;
    
    public function create(Task $task): Task | \Exception;
    
    public function update(Task $task): Task | \Exception;
    
    public function delete(int $id): bool | \Exception;
}
