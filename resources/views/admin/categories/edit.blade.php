@extends('layouts.admin')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-ocean-primary">
            <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Categories
        </a>
    </div>

    <form
        method="POST"
        action="{{ route('admin.categories.update', $category) }}"
        enctype="multipart/form-data"
        class="card max-w-2xl p-8"
        x-data="{ preview: @js($category->image_url) }"
    >
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required class="input-field @error('name') border-red-500 @enderror">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="slug" class="mb-2 block text-sm font-medium text-gray-700">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}" class="input-field @error('slug') border-red-500 @enderror">
                @error('slug')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Image</label>
                <div class="flex items-start gap-4">
                    <template x-if="preview">
                        <img :src="preview" alt="Preview" class="h-24 w-24 rounded-xl object-cover ring-2 ring-ocean-primary/20">
                    </template>
                    <div class="flex-1">
                        <input
                            type="file"
                            name="image"
                            accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-lg file:border-0 file:bg-ocean-primary/10 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-ocean-primary hover:file:bg-ocean-primary/20"
                            @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : preview"
                        >
                        <p class="mt-1 text-xs text-gray-500">Leave empty to keep current image. PNG, JPG up to 2MB</p>
                        @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                <input type="hidden" name="status" value="0">
                <label class="inline-flex cursor-pointer items-center gap-2">
                    <input type="checkbox" name="status" value="1" {{ old('status', $category->status) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-ocean-primary focus:ring-ocean-primary">
                    <span class="text-sm text-gray-600">Active</span>
                </label>
                @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="meta_title" class="mb-2 block text-sm font-medium text-gray-700">Meta Title</label>
                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $category->meta_title) }}" class="input-field @error('meta_title') border-red-500 @enderror">
                @error('meta_title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="meta_description" class="mb-2 block text-sm font-medium text-gray-700">Meta Description</label>
                <textarea name="meta_description" id="meta_description" rows="3" class="input-field @error('meta_description') border-red-500 @enderror">{{ old('meta_description', $category->meta_description) }}</textarea>
                @error('meta_description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mt-8 flex gap-3">
            <button type="submit" class="btn-primary">Update Category</button>
            <a href="{{ route('admin.categories.index') }}" class="btn-outline">Cancel</a>
        </div>
    </form>
@endsection
