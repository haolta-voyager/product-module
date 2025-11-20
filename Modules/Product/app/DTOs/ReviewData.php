<?php

namespace Modules\Product\DTOs;

use Modules\Product\Enums\Rating;

class ReviewData
{
    public function __construct(
        public readonly int $productId,
        public readonly string $authorName,
        public readonly Rating $rating,
        public readonly string $comment,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            productId: (int) $data['product_id'],
            authorName: $data['author_name'],
            rating: Rating::from((int) $data['rating']),
            comment: $data['comment'],
        );
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->productId,
            'author_name' => $this->authorName,
            'rating' => $this->rating->value,
            'comment' => $this->comment,
        ];
    }
}
