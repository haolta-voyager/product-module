<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Product\DTOs\ProductData;
use Modules\Product\Http\Requests\StoreProductRequest;
use Modules\Product\Http\Requests\UpdateProductRequest;
use Modules\Product\Services\ProductService;
use Modules\Product\Services\CategoryService;
use Modules\Product\Services\ReviewService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService,
        private CategoryService $categoryService,
        private ReviewService $reviewService
    ) {}

    public function index(): View
    {
        $categoryId = request('category_id');
        $search = request('search');
        $categories = $this->categoryService->getAllCategories();
        
        if ($search && $categoryId) {
            // Search with category filter
            $products = $this->productService->searchProductsWithCategory($search, $categoryId, perPage: 10);
        } elseif ($search) {
            // Search only
            $products = $this->productService->searchProducts($search, perPage: 10);
        } elseif ($categoryId) {
            // Category filter only
            $products = $this->productService->getProductsByCategory($categoryId, perPage: 10);
        } else {
            // No filters
            $products = $this->productService->getProductsPaginated(perPage: 10);
        }

        return view('product::products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = $this->categoryService->getAllCategories();
        
        return view('product::products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $productData = ProductData::fromArray($request->validated());
        $this->productService->createProduct($productData);
        
        return redirect()->route('products.index')
            ->with('success', 'Product created successfully');
    }

    public function show(int $id): View
    {
        $product = $this->productService->getProductById($id);
        
        if (!$product) {
            abort(404);
        }
        
        // Load reviews from MongoDB
        $reviews = $this->reviewService->getReviewsByProduct($id);
        
        // Get average rating and review count
        $averageRating = $this->reviewService->getProductAverageRating($id);
        $reviewCount = $this->reviewService->getProductReviewCount($id);
        
        return view('product::products.show', compact('product', 'reviews', 'averageRating', 'reviewCount'));
    }

    public function edit(int $id): View
    {
        $product = $this->productService->getProductById($id);
        $categories = $this->categoryService->getAllCategories();

        if (!$product) {
            abort(404);
        }

        return view('product::products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, int $id): RedirectResponse
    {
        $productData = ProductData::fromArray($request->validated());
        $updated = $this->productService->updateProduct($id, $productData);

        if (!$updated) {
            return back()->with('error', 'Product not found');
        }
        
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(int $id): RedirectResponse
    {
        $deleted = $this->productService->deleteProduct($id);
        
        if (!$deleted) {
            return back()->with('error', 'Product not found');
        }
        
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
