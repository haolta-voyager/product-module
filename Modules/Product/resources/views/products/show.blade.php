@extends('product::layouts.master')

@section('title', $product->name)

@section('content')
<div class="px-4 sm:px-0">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $product->name }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Product details and reviews</p>
            </div>
            @auth
                @if(auth()->user()->isUser())
                    <div>
                        <a href="{{ route('products.edit', $product->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">
                            Edit
                        </a>
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Back to List
                        </a>
                    </div>
                @endif
            @endauth
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200">
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Category</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $product->category->name ?? 'N/A' }}
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Price</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 font-semibold text-lg">
                        ${{ number_format($product->price, 2) }}
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $product->description ?? 'No description provided.' }}
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $product->created_at->format('M d, Y H:i') }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Reviews Section - Visible to all users -->
    <div class="mt-8 bg-white shadow sm:rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Customer Reviews ({{ $reviewCount }})</h3>
                @if($reviewCount > 0)
                    <div class="flex items-center mt-2">
                        <span class="text-2xl font-bold text-yellow-500">{{ number_format($averageRating, 1) }}</span>
                        <span class="ml-2 text-gray-600">/ 5.0</span>
                        <span class="ml-3 text-yellow-400 text-xl">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($averageRating))
                                    ★
                                @else
                                    ☆
                                @endif
                            @endfor
                        </span>
                    </div>
                @endif
            </div>
            @auth
                @if(auth()->user()->isCustomer())
                    <a href="{{ route('reviews.index', $product->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                        Add Review
                    </a>
                @endif
            @endauth
        </div>

        @if($reviews->isEmpty())
            <p class="text-gray-500 text-sm">No reviews yet. Be the first to review this product!</p>
        @else
            <div class="space-y-4">
                @foreach($reviews as $review)
                    <div class="border-b border-gray-200 pb-4 last:border-b-0">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $review->author_name }}</h4>
                                <div class="flex items-center mt-1">
                                    <span class="text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating->value)
                                                ★
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                    </span>
                                    <span class="ml-2 text-sm text-gray-500">({{ $review->rating->value }}/5)</span>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-700 text-sm">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
