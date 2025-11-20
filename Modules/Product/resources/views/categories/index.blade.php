@extends('product::layouts.master')

@section('title', 'Categories')

@section('content')
<div class="px-4 sm:px-0">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold text-gray-900">Categories</h1>
        </div>
        @auth
            @if(auth()->user()->isUser())
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <a href="{{ route('categories.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                        Add Category
                    </a>
                </div>
            @endif
        @endauth
    </div>

    <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($categories as $category)
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900">{{ $category->name }}</h3>
                    <p class="mt-1 text-sm text-gray-500">Slug: {{ $category->slug }}</p>
                    <div class="mt-4 flex space-x-3">
                        @auth
                            @if(auth()->user()->isUser())
                                <a href="{{ route('categories.edit', $category->id) }}" class="text-sm text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="text-sm text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-white rounded-lg shadow">
                <p class="text-gray-500">No categories found.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($categories->hasPages())
        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    @endif
</div>
@endsection
