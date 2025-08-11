<?php

namespace App\Domain\UserTask;

/**
 * Class UserTask
 *
 * Represents a user task.
 */
class UserTask
{
	private int $id;
    
	private int $userId;
    
	private int $taskId;
    
	private \DateTimeImmutable $createdAt;
    
	private \DateTimeImmutable $updatedAt;

    /**
     * UserTask constructor.
     *
     * @param int $id
     * @param int $userId
     * @param int $taskId
     * @param \DateTimeImmutable $createdAt
     * @param \DateTimeImmutable $updatedAt
     */
    public function __construct(
        int $id,
        int $userId,
        int $taskId,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->taskId = $taskId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
    
	public function id(): int { return $this->id; }
    
	public function userId(): int { return $this->userId; }
    
	public function taskId(): int { return $this->taskId; }
    
	public function createdAt(): \DateTimeImmutable { return $this->createdAt; }
    
	public function updatedAt(): \DateTimeImmutable { return $this->updatedAt; }
}