<?php

namespace Modules\Product\Services;

use Modules\Product\DTOs\ReviewData;
use Modules\Product\Models\Review;
use Modules\Product\Repositories\ReviewRepository;
use Illuminate\Support\Collection;

class ReviewService
{
    public function __construct(
        private ReviewRepository $reviewRepository
    ) {}

    public function getReviewsByProduct(int $productId): Collection
    {
        return $this->reviewRepository->findByProductId($productId);
    }

    public function getProductAverageRating(int $productId): float
    {
        return $this->reviewRepository->getAverageRating($productId);
    }

    public function getProductReviewCount(int $productId): int
    {
        return $this->reviewRepository->countByProductId($productId);
    }

    public function createReview(ReviewData $data): Review
    {
        return $this->reviewRepository->create($data->toArray());
    }

    public function deleteReview(string $id): bool
    {
        return $this->reviewRepository->delete($id);
    }
}
