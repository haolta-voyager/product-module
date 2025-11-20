<?php

namespace Modules\Product\DTOs;

use Illuminate\Support\Str;

class CategoryData
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            slug: $data['slug'] ?? Str::slug($data['name']),
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
        ];
    }
}
