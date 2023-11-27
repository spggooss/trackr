<?php

namespace App\Models\Package;

class EloquentReviewRepository implements ReviewRepository
{
    /**
     * @return Review[]
     */
    public function all(): array
    {
        return Review::all()->all();
    }

    /**
     * @param Review $review
     * @return Review
     */
    public function store(Review $review): Review
    {
        $review->save();
        return $review;
    }

    /**
     * @param int $id
     * @return Review|null
     */
    public function findById(int $id, array $relations = []): ?Review
    {
        $builder = Review::where('id', $id);

        if (!empty($relations)) {
            $builder = $builder->with($relations);
        }

        return $builder->first();
    }
}
