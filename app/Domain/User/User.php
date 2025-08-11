<?php

namespace App\Domain\User;

/**
 * Class User
 *
 * Represents a user.
 */
class User
{
	private int $id;
    
	private string $name;
    
	private string $email;
    
	private string $password;

	private \DateTimeImmutable $createdAt;
    
	private \DateTimeImmutable $updatedAt;

    /**
     * User constructor.
     *
     * @param int $id
     * @param string $name
     * @param string $email
     * @param string $password
     * @param \DateTimeImmutable $createdAt
     * @param \DateTimeImmutable $updatedAt
     */
    public function __construct(
        int $id,
        string $name,
        string $email,
        string $password,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function id(): int { return $this->id; }
    
    public function name(): string { return $this->name; }
    
    public function email(): string { return $this->email; }
    
    public function password(): string { return $this->password; }

    public function createdAt(): \DateTimeImmutable { return $this->createdAt; }
    
    public function updatedAt(): \DateTimeImmutable { return $this->updatedAt; }
}