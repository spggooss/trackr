<?php

namespace App\Models\Package;

interface ReviewRepository
{
    /**
     * @return Review[]
     */
    public function all(): array;

    /**
     * @param Review $review
     * @return Review
     */
    public function store(Review $review): Review;

    /**
     * @param int $id
     * @return Review|null
     */
    public function findById(int $id, array $relations): ?Review;
}
