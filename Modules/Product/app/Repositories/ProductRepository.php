<?php

namespace Modules\Product\Repositories;

use Modules\Product\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public function __construct(
        private Product $model
    ) {}

    public function findById(int $id): ?Product
    {
        return $this->model->find($id);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->with('category')
            ->orderBy('id', 'asc')
            ->paginate($perPage);
    }

    public function findByCategory(int $categoryId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->where('category_id', $categoryId)
            ->with('category')
            ->orderBy('id', 'asc')
            ->paginate($perPage);
    }

    public function create(array $data): Product
    {
        return $this->model->create($data);
    }

    public function update(Product $product, array $data): bool
    {
        return $product->update($data);
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }

    public function search(string $keyword, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->where('name', 'like', "%{$keyword}%")
            ->with('category')
            ->orderBy('id', 'asc')
            ->paginate($perPage);
    }

    public function searchWithCategory(string $keyword, int $categoryId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->where('category_id', $categoryId)
            ->where('name', 'like', "%{$keyword}%")
            ->with('category')
            ->orderBy('id', 'asc')
            ->paginate($perPage);
    }
}
