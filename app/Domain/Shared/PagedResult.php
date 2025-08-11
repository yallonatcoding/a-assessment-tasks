<?php

namespace App\Domain\Shared;

class PagedResult
{
    /**
     * @param array<int, mixed> $items
     * @param int $total
     */
    public function __construct(
        public array $items,
        public int $total,
        public bool $done,
        public int $page,
        public int $perPage
    ) {}
}
