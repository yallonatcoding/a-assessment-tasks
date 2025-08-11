<?php

namespace App\Infrastructure\Eloquent\User;

use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use App\Models\User as EloquentUserModel;
use App\Infrastructure\Eloquent\User\UserMapper;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

/**
 * Eloquent implementation of the UserRepositoryInterface.
 */
class EloquentUserRepository implements UserRepositoryInterface
{
    public function register(User $user): bool
    {
        $model = null;

        try {
            $model = EloquentUserModel::create(UserMapper::toPersistence($user));
        } catch (QueryException $e) {
            throw new \Exception("Failed to create user: " . $e->getMessage());
        }

        return $model !== null;
    }

    public function login(string $email, string $password): ?string
    {
        if (Auth::attempt(compact('email', 'password'))) {
            $user = Auth::user();
            return $user->createToken('token-name')->accessToken;
        }

        return null;
    }

    public function logout(): void
    {
        Auth::logout();
    }
}