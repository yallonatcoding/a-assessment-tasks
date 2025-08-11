<?php

namespace App\Domain\User;

/**
 * Interface UserRepositoryInterface
 * 
 * Defines the contract for a User repository.
 */
interface UserRepositoryInterface
{
    public function register(User $user): bool;
    
    public function login(string $email, string $password): ?string;
    
    public function logout(): void;
}
