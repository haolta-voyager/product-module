<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Modules\Product\DTOs\ReviewData;
use Modules\Product\Http\Requests\StoreReviewRequest;
use Modules\Product\Services\ReviewService;
use Modules\Product\Services\ProductService;
use Modules\User\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class ReviewController extends Controller
{
    public function __construct(
        private ReviewService $reviewService,
        private ProductService $productService
    ) {}

    public function index(int $productId): View
    {
        $product = $this->productService->getProductById($productId);
        
        if (!$product) {
            abort(404);
        }
        
        /** @var User $user */
        $user = Auth::user();
        $author_name = $user->name;
        $reviews = $this->reviewService->getReviewsByProduct($productId);
        $averageRating = $this->reviewService->getProductAverageRating($productId);
        $reviewCount = $this->reviewService->getProductReviewCount($productId);
        
        return view('product::reviews.index', compact(
            'product',
            'reviews',
            'averageRating',
            'reviewCount',
            'author_name'
        ));
    }

    public function store(StoreReviewRequest $request): RedirectResponse
    {
        $reviewData = ReviewData::fromArray($request->validated());
        $this->reviewService->createReview($reviewData);
        
        return back()->with('success', 'Review added successfully');
    }
}
