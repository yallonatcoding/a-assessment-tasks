<?php

namespace App\Domain\Task;

/**
 * Class Task
 *
 * Represents a task.
 */

class Task
{
    private int $id;

    private string $title;
    
    private ?string $description;
    
    private bool $isCompleted;
    
    private \DateTimeImmutable $createdAt;
    
    private \DateTimeImmutable $updatedAt;

    /**
     * Task constructor.
     *
     * @param int $id
     * @param string $title
     * @param string|null $description
     * @param bool $isCompleted
     * @param \DateTimeImmutable $createdAt
     * @param \DateTimeImmutable $updatedAt
     */
    public function __construct(
        int $id,
        string $title,
        ?string $description = '',
        bool $isCompleted = false,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
    ) {
        $this->id = $id;        
        $this->title = $title;        
        $this->description = $description;        
        $this->isCompleted = $isCompleted;        
        $this->createdAt = $createdAt;        
        $this->updatedAt = $updatedAt;
    }
    
    
    public function id(): int { return $this->id; }
    
    public function title(): string { return $this->title; }
    
    public function description(): ?string { return $this->description; }
    
    public function isCompleted(): bool { return $this->isCompleted; }
    
    public function createdAt(): \DateTimeImmutable { return $this->createdAt; }
    
    public function updatedAt(): \DateTimeImmutable { return $this->updatedAt; }
}
