<?php

namespace Modules\Product\Services;

use Modules\Product\DTOs\ProductData;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\ProductRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    public function __construct(
        private ProductRepository $productRepository
    ) {}

    public function getAllProducts(): Collection
    {
        return $this->productRepository->all();
    }

    public function getProductsPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->productRepository->paginate($perPage);
    }

    public function getProductById(int $id): ?Product
    {
        return $this->productRepository->findById($id);
    }

    public function getProductsByCategory(int $categoryId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->productRepository->findByCategory($categoryId, $perPage);
    }

    public function searchProducts(string $keyword, int $perPage = 10): LengthAwarePaginator
    {
        return $this->productRepository->search($keyword, $perPage);
    }

    public function searchProductsWithCategory(string $keyword, int $categoryId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->productRepository->searchWithCategory($keyword, $categoryId, $perPage);
    }

    public function createProduct(ProductData $data): Product
    {
        return $this->productRepository->create($data->toArray());
    }

    public function updateProduct(int $id, ProductData $data): bool
    {
        $product = $this->productRepository->findById($id);
        
        if (!$product) {
            return false;
        }

        return $this->productRepository->update($product, $data->toArray());
    }

    public function deleteProduct(int $id): bool
    {
        $product = $this->productRepository->findById($id);
        
        if (!$product) {
            return false;
        }

        return $this->productRepository->delete($product);
    }
}
