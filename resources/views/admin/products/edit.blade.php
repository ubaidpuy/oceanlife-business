@extends('layouts.admin')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-ocean-primary">
            <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Products
        </a>
    </div>

    <form
        method="POST"
        action="{{ route('admin.products.update', $product) }}"
        enctype="multipart/form-data"
        class="card max-w-3xl p-8"
        x-data="{
            newPreviews: [],
            addPreviews(event) {
                const files = Array.from(event.target.files);
                files.forEach(file => {
                    this.newPreviews.push(URL.createObjectURL(file));
                });
            },
            removeNewPreview(index) {
                this.newPreviews.splice(index, 1);
            }
        }"
    >
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div class="grid gap-6 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="name" class="mb-2 block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required class="input-field @error('name') border-red-500 @enderror">
                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="slug" class="mb-2 block text-sm font-medium text-gray-700">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}" class="input-field @error('slug') border-red-500 @enderror">
                    @error('slug')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="category_id" class="mb-2 block text-sm font-medium text-gray-700">Category <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" required class="input-field @error('category_id') border-red-500 @enderror">
                        <option value="">Select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="description" class="mb-2 block text-sm font-medium text-gray-700">Description <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="5" required class="input-field @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                    @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="price" class="mb-2 block text-sm font-medium text-gray-700">Price <span class="text-red-500">*</span></label>
                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required class="input-field @error('price') border-red-500 @enderror">
                    @error('price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="discount_price" class="mb-2 block text-sm font-medium text-gray-700">Discount Price</label>
                    <input type="number" name="discount_price" id="discount_price" value="{{ old('discount_price', $product->discount_price) }}" step="0.01" min="0" class="input-field @error('discount_price') border-red-500 @enderror">
                    @error('discount_price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="shipping_charge" class="mb-2 block text-sm font-medium text-gray-700">Shipping Charge</label>
                    <input type="number" name="shipping_charge" id="shipping_charge" value="{{ old('shipping_charge', $product->shipping_charge) }}" step="0.01" min="0" class="input-field @error('shipping_charge') border-red-500 @enderror">
                    @error('shipping_charge')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="stock" class="mb-2 block text-sm font-medium text-gray-700">Stock <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" min="0" required class="input-field @error('stock') border-red-500 @enderror">
                    @error('stock')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex flex-wrap gap-6">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Featured <span class="text-red-500">*</span></label>
                    <input type="hidden" name="featured" value="0">
                    <label class="inline-flex cursor-pointer items-center gap-2">
                        <input type="checkbox" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-ocean-primary focus:ring-ocean-primary">
                        <span class="text-sm text-gray-600">Mark as featured</span>
                    </label>
                    @error('featured')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                    <input type="hidden" name="status" value="0">
                    <label class="inline-flex cursor-pointer items-center gap-2">
                        <input type="checkbox" name="status" value="1" {{ old('status', $product->status) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-ocean-primary focus:ring-ocean-primary">
                        <span class="text-sm text-gray-600">Active</span>
                    </label>
                    @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            @if($product->images->isNotEmpty())
                <div>
                    <label class="mb-3 block text-sm font-medium text-gray-700">Current Images</label>
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($product->images as $image)
                            <div class="relative rounded-xl border border-gray-200 p-3 {{ $image->is_primary ? 'ring-2 ring-ocean-primary' : '' }}">
                                <img src="{{ $image->url }}" alt="Product image" class="h-32 w-full rounded-lg object-cover">
                                @if($image->is_primary)
                                    <span class="absolute left-5 top-5 badge bg-ocean-primary text-white">Primary</span>
                                @endif
                                <div class="mt-3 space-y-2">
                                    <label class="flex cursor-pointer items-center gap-2 text-sm text-red-600">
                                        <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
                                        Remove
                                    </label>
                                    <label class="flex cursor-pointer items-center gap-2 text-sm text-gray-700">
                                        <input type="radio" name="primary_image_id" value="{{ $image->id }}" {{ old('primary_image_id', $product->images->firstWhere('is_primary', true)?->id) == $image->id ? 'checked' : '' }} class="h-4 w-4 border-gray-300 text-ocean-primary focus:ring-ocean-primary">
                                        Set as primary
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('remove_images')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    @error('primary_image_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            @endif

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Add New Images</label>
                <input
                    type="file"
                    name="images[]"
                    accept="image/*"
                    multiple
                    class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-lg file:border-0 file:bg-ocean-primary/10 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-ocean-primary hover:file:bg-ocean-primary/20"
                    @change="addPreviews($event)"
                >
                <p class="mt-1 text-xs text-gray-500">PNG, JPG up to 4MB each</p>
                @error('images')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                @error('images.*')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror

                <div class="mt-4 flex flex-wrap gap-3" x-show="newPreviews.length > 0">
                    <template x-for="(preview, index) in newPreviews" :key="index">
                        <div class="relative">
                            <img :src="preview" alt="New preview" class="h-24 w-24 rounded-xl object-cover ring-2 ring-ocean-secondary/30">
                            <button type="button" @click="removeNewPreview(index)" class="absolute -right-2 -top-2 flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-xs text-white hover:bg-red-600">&times;</button>
                        </div>
                    </template>
                </div>
            </div>

            <div>
                <label for="meta_title" class="mb-2 block text-sm font-medium text-gray-700">Meta Title</label>
                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $product->meta_title) }}" class="input-field @error('meta_title') border-red-500 @enderror">
                @error('meta_title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="meta_description" class="mb-2 block text-sm font-medium text-gray-700">Meta Description</label>
                <textarea name="meta_description" id="meta_description" rows="3" class="input-field @error('meta_description') border-red-500 @enderror">{{ old('meta_description', $product->meta_description) }}</textarea>
                @error('meta_description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mt-8 flex gap-3">
            <button type="submit" class="btn-primary">Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn-outline">Cancel</a>
        </div>
    </form>
@endsection
