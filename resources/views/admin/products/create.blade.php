@extends('admin.layouts.app')

@section('title', 'Create Product')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Add New Product</h1>
        <a href="{{ route('admin.products.index') }}" 
           class="text-gray-600 hover:text-gray-900">
            ← Back to Products
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                    <input type="text" 
                           name="name" 
                           id="name"
                           value="{{ old('name') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0EA5B9] focus:border-transparent"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price (Rs.) *</label>
                    <input type="number" 
                           name="price" 
                           id="price"
                           value="{{ old('price') }}"
                           step="0.01"
                           min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0EA5B9] focus:border-transparent"
                           required>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <select name="category" 
                            id="category"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0EA5B9] focus:border-transparent"
                            required>
                        <option value="">Select a category</option>
                        <option value="juices" {{ old('category') == 'juices' ? 'selected' : '' }}>Juices</option>
                        <option value="soft-drinks" {{ old('category') == 'soft-drinks' ? 'selected' : '' }}>Soft Drinks</option>
                        <option value="dairy" {{ old('category') == 'dairy' ? 'selected' : '' }}>Dairy</option>
                        <option value="energy-drinks" {{ old('category') == 'energy-drinks' ? 'selected' : '' }}>Energy Drinks</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                    <input type="file" 
                           name="image" 
                           id="image"
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0EA5B9] focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500">JPEG, PNG, JPG, GIF up to 2MB</p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" 
                              id="description"
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0EA5B9] focus:border-transparent">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit"
                        class="bg-[#0EA5B9] hover:bg-[#0c8a9e] text-white px-6 py-3 rounded-lg transition-colors">
                    Create Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection