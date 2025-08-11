<?php

namespace App\Infrastructure\Auth;

use App\Domain\Auth\UserPermissionValidatorInterface;
use Illuminate\Support\Facades\DB;

class DatabaseUserPermissionValidator implements UserPermissionValidatorInterface
{
    public function canModify(int $userId, int $resourceId): bool
    {
        return DB::table('users_tasks')
            ->where('user_id', $userId)
            ->where('task_id', $resourceId)
            ->exists();
    }
}
