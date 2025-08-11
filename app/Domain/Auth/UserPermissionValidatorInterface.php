<?php

namespace App\Domain\Auth;

interface UserPermissionValidatorInterface
{
    public function canModify(int $userId, int $resourceId): bool;
}