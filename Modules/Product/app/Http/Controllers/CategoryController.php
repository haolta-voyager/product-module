<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Product\DTOs\CategoryData;
use Modules\Product\Http\Requests\StoreCategoryRequest;
use Modules\Product\Http\Requests\UpdateCategoryRequest;
use Modules\Product\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $categoryService
    ) {}

    public function index(): View
    {
        $categories = $this->categoryService->getCategoriesPaginated(perPage: 6);
        
        return view('product::categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('product::categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $categoryData = CategoryData::fromArray($request->validated());
        $this->categoryService->createCategory($categoryData);
        
        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully');
    }

    public function show(int $id): View
    {
        $category = $this->categoryService->getCategoryById($id);
        
        if (!$category) {
            abort(404);
        }
        
        // @phpstan-ignore-next-line
        return view('product::categories.show', compact('category'));
    }

    public function edit(int $id): View
    {
        $category = $this->categoryService->getCategoryById($id);
        
        if (!$category) {
            abort(404);
        }
        
        return view('product::categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, int $id): RedirectResponse
    {
        $categoryData = CategoryData::fromArray($request->validated());
        $updated = $this->categoryService->updateCategory($id, $categoryData);
        
        if (!$updated) {
            return back()->with('error', 'Category not found');
        }
        
        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy(int $id): RedirectResponse
    {
        $deleted = $this->categoryService->deleteCategory($id);
        
        if (!$deleted) {
            return back()->with('error', 'Category not found');
        }
        
        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
