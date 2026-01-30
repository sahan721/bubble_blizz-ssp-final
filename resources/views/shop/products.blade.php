@extends('layouts.app')

@section('title', 'Products - Bubble Blizz')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Our Products</h1>
            <p class="text-gray-600">Browse our collection of fresh beverages</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                    <h3 class="font-semibold text-lg mb-4">Categories</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('shop.products') }}" 
                               class="block py-2 px-3 rounded {{ !request()->category ? 'bg-indigo-100 text-indigo-700' : 'hover:bg-gray-100' }}">
                                All Products
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('shop.products', ['category' => $category]) }}" 
                                   class="block py-2 px-3 rounded {{ request()->category == $category ? 'bg-indigo-100 text-indigo-700' : 'hover:bg-gray-100' }}">
                                    {{ ucfirst($category) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:w-3/4">
                <!-- Search Bar -->
                <div class="bg-white rounded-lg shadow p-4 mb-6">
                    <form method="GET" action="{{ route('shop.products') }}">
                        <div class="flex gap-2">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request()->search }}" 
                                   placeholder="Search products..."
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <button type="submit" 
                                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                                Search
                            </button>
                        </div>
                        @if(request()->category)
                            <input type="hidden" name="category" value="{{ request()->category }}">
                        @endif
                    </form>
                </div>

                <!-- Products Count -->
                <div class="mb-4">
                    <p class="text-gray-600">
                        Showing {{ $products->count() }} of {{ $products->total() }} products
                        @if(request()->category)
                            in <span class="font-semibold">{{ ucfirst(request()->category) }}</span>
                        @endif
                    </p>
                </div>

                <!-- Products Grid -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                                <div class="h-48 bg-gray-200 flex items-center justify-center">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-gray-400">No Image</span>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg mb-2">{{ $product->name }}</h3>
                                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($product->description, 80) }}</p>
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="text-xl font-bold text-indigo-600">රු{{ number_format($product->price, 2) }}</span>
                                        <span class="text-sm text-gray-500 capitalize bg-gray-100 px-2 py-1 rounded">{{ $product->category }}</span>
                                    </div>
                                    <div class="flex gap-2">
                                        <button onclick="window.location='{{ route('login') }}'" 
                                                class="flex-1 bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition text-center">
                                            Add to Cart
                                        </button>
                                        <button onclick="window.location='{{ route('login') }}'" 
                                                class="p-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="mt-8">
                            {{ $products->links() }}
                        </div>
                    @endif
                @else
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No products found</h3>
                        <p class="text-gray-600 mb-4">Try adjusting your search or filter criteria</p>
                        <a href="{{ route('shop.products') }}" class="text-indigo-600 hover:underline">View all products</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection