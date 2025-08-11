<?php

namespace App\Domain\Invitation;

/**
 * Class Invitation
 *
 * Represents an invitation.
 */
class Invitation
{
    private int $id;
    
    private string $uuid;
    
    private int $userId;
    
    private int $invitatedUserId;
    
    private bool $isAccepted;

    private \DateTimeImmutable $createdAt;
    
    private \DateTimeImmutable $updatedAt;

    /**
     * Invitation constructor.
     */
    public function __construct(
        int $id,
        string $uuid,
        int $userId,
        int $invitatedUserId,
        bool $isAccepted = false,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt
    ) {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->userId = $userId;
        $this->invitatedUserId = $invitatedUserId;
        $this->isAccepted = $isAccepted;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

	public function id(): int { return $this->id; }
    
	public function uuid(): string { return $this->uuid; }
    
	public function userId(): int { return $this->userId; }
    
	public function invitatedUserId(): int { return $this->invitatedUserId; }
    
	public function isAccepted(): bool { return $this->isAccepted; }

	public function createdAt(): \DateTimeImmutable { return $this->createdAt; }
    
	public function updatedAt(): \DateTimeImmutable { return $this->updatedAt; }
}
