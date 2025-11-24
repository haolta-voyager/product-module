<?php

namespace Modules\Product\Repositories;

use Modules\Product\Models\Review;
use Illuminate\Support\Collection;

class ReviewRepository
{
    public function __construct(
        private Review $model
    ) {}

    public function findByProductId(int $productId): Collection
    {
        return $this->model
            ->where('product_id', $productId)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function create(array $data): Review
    {
        return $this->model->create($data);
    }

    public function delete(string $id): bool
    {
        $review = $this->model->find($id);
        
        if (!$review) {
            return false;
        }
        
        return $review->delete();
    }

    public function getAverageRating(int $productId): float
    {
        return $this->model
            ->where('product_id', $productId)
            ->avg('rating') ?? 0.0;
    }

    public function countByProductId(int $productId): int
    {
        return $this->model
            ->where('product_id', $productId)
            ->count();
    }
}
