@extends('product::layouts.master')

@section('title', 'Reviews for ' . $product->name)

@section('content')
<div class="px-4 sm:px-0">
    <div class="bg-white shadow sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:p-6">
            <h2 class="text-2xl font-semibold text-gray-900">{{ $product->name }}</h2>
            <p class="mt-1 text-sm text-gray-600">{{ $product->description }}</p>
            <div class="mt-4">
                <span class="text-3xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
            </div>
            <div class="mt-4 flex items-center">
                <span class="text-2xl font-bold text-yellow-500">{{ number_format($averageRating, 1) }}</span>
                <span class="ml-2 text-gray-600">/ 5.0</span>
                <span class="ml-4 text-sm text-gray-500">({{ $reviewCount }} {{ Str::plural('review', $reviewCount) }})</span>
            </div>
        </div>
    </div>

    <div class="bg-white shadow sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Write a Review</h3>
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <div class="space-y-4">
                    <div>
                        <p class="mt-1 text-sm text-gray-900 font-medium">{{ $author_name }}</p>
                        <input type="hidden" name="author_name" value="{{ $author_name }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                        <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', '') }}">
                        <div class="flex items-center gap-1 star-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" class="star-btn text-3xl focus:outline-none transition-colors duration-150 {{ old('rating') >= $i ? 'text-yellow-400' : 'text-gray-300' }}" data-rating="{{ $i }}">
                                    ★
                                </button>
                            @endfor
                        </div>
                        @error('rating')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const stars = document.querySelectorAll('.star-btn');
                            const ratingInput = document.getElementById('rating-input');
                            
                            stars.forEach(star => {
                                star.addEventListener('click', function() {
                                    const rating = this.getAttribute('data-rating');
                                    ratingInput.value = rating;
                                    
                                    // Update star colors
                                    stars.forEach((s, index) => {
                                        if (index < rating) {
                                            s.classList.remove('text-gray-300');
                                            s.classList.add('text-yellow-400');
                                        } else {
                                            s.classList.remove('text-yellow-400');
                                            s.classList.add('text-gray-300');
                                        }
                                    });
                                });
                                
                                // Hover effect
                                star.addEventListener('mouseenter', function() {
                                    const rating = this.getAttribute('data-rating');
                                    stars.forEach((s, index) => {
                                        if (index < rating) {
                                            s.classList.add('text-yellow-300');
                                        }
                                    });
                                });
                                
                                star.addEventListener('mouseleave', function() {
                                    const currentRating = ratingInput.value;
                                    stars.forEach((s, index) => {
                                        s.classList.remove('text-yellow-300');
                                        if (index < currentRating) {
                                            s.classList.add('text-yellow-400');
                                        } else {
                                            s.classList.remove('text-yellow-400');
                                            s.classList.add('text-gray-300');
                                        }
                                    });
                                });
                            });
                        });
                    </script>

                    <div>
                        <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                        <textarea name="comment" id="comment" rows="4" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('comment') border-red-500 @enderror">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('products.show', $product->id) }}" class="mr-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Submit Review
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">All Reviews</h3>
            <div class="space-y-6">
                @forelse($reviews as $review)
                    <div class="border-b border-gray-200 pb-6 last:border-0 last:pb-0">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $review->author_name }}</p>
                                <div class="mt-1 flex items-center">
                                    <span class="text-yellow-500">{{ $review->rating->stars() }}</span>
                                    <span class="ml-2 text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        <p class="mt-3 text-gray-700">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">No reviews yet. Be the first to review this product!</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
