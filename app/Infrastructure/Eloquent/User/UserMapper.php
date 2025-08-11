<?php

namespace App\Infrastructure\Eloquent\User;

use App\Domain\User\User;
use App\Models\User as EloquentUserModel;

/**
 * Mapper class to convert between User domain objects and Eloquent models.
 */
class UserMapper
{
    public static function toDomain(EloquentUserModel $model): User
    {
        return new User(
            $model->id,
            $model->name,
            $model->email,
            $model->password,
            $model->created_at,
            $model->updated_at
        );
    }

    public static function toPersistence(User $user): array
    {
        return [
            'name' => $user->name(),
            'email' => $user->email(),
            'password' => $user->password(),
            'created_at' => $user->createdAt(),
            'updated_at' => $user->updatedAt(),
        ];
    }
}