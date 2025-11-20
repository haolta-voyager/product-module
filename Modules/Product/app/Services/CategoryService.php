<?php

namespace Modules\Product\Services;

use Modules\Product\DTOs\CategoryData;
use Modules\Product\Models\Category;
use Modules\Product\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {}

    public function getAllCategories(): Collection
    {
        return $this->categoryRepository->all();
    }

    public function getCategoriesPaginated(int $perPage = 6): LengthAwarePaginator
    {
        return $this->categoryRepository->paginate($perPage);
    }

    public function getCategoryById(int $id): ?Category
    {
        return $this->categoryRepository->findById($id);
    }

    public function getCategoryBySlug(string $slug): ?Category
    {
        return $this->categoryRepository->findBySlug($slug);
    }

    public function createCategory(CategoryData $data): Category
    {
        return $this->categoryRepository->create($data->toArray());
    }

    public function updateCategory(int $id, CategoryData $data): bool
    {
        $category = $this->categoryRepository->findById($id);
        
        if (!$category) {
            return false;
        }

        return $this->categoryRepository->update($category, $data->toArray());
    }

    public function deleteCategory(int $id): bool
    {
        $category = $this->categoryRepository->findById($id);
        
        if (!$category) {
            return false;
        }

        return $this->categoryRepository->delete($category);
    }
}
