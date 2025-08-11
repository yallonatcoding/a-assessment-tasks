<?php

namespace App\Domain\Invitation;

/**
 * Interface InvitationRepositoryInterface
 *
 * Defines the contract for an Invitation repository.
 */
interface InvitationRepositoryInterface
{
    public function findByUser(int $userId): array | \Exception;
    
    public function find(int $id): Invitation | \Exception;
    
    public function create(Invitation $invitation): Invitation | \Exception;
    
    public function update(Invitation $invitation): Invitation | \Exception;
    
    public function delete(int $id): bool | \Exception;
}
