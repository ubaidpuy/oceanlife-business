@extends('layouts.admin')

@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')
    <form
        method="POST"
        action="{{ route('admin.settings.update') }}"
        enctype="multipart/form-data"
        class="card max-w-3xl p-8"
        x-data="{ preview: @js($settings->logo_url) }"
    >
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div>
                <label for="shop_name" class="mb-2 block text-sm font-medium text-gray-700">Shop Name <span class="text-red-500">*</span></label>
                <input type="text" name="shop_name" id="shop_name" value="{{ old('shop_name', $settings->shop_name) }}" required class="input-field @error('shop_name') border-red-500 @enderror">
                @error('shop_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Logo</label>
                <div class="flex items-start gap-4">
                    <template x-if="preview">
                        <img :src="preview" alt="Logo preview" class="h-20 w-20 rounded-xl object-contain ring-2 ring-ocean-primary/20 bg-gray-50 p-1">
                    </template>
                    <div class="flex-1">
                        <input
                            type="file"
                            name="logo"
                            accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-lg file:border-0 file:bg-ocean-primary/10 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-ocean-primary hover:file:bg-ocean-primary/20"
                            @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : preview"
                        >
                        <p class="mt-1 text-xs text-gray-500">Leave empty to keep current logo. PNG, JPG up to 2MB</p>
                        @error('logo')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div>
                <label for="address" class="mb-2 block text-sm font-medium text-gray-700">Address</label>
                <textarea name="address" id="address" rows="3" class="input-field @error('address') border-red-500 @enderror">{{ old('address', $settings->address) }}</textarea>
                @error('address')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="phone" class="mb-2 block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $settings->phone) }}" class="input-field @error('phone') border-red-500 @enderror">
                    @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="whatsapp" class="mb-2 block text-sm font-medium text-gray-700">WhatsApp</label>
                    <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $settings->whatsapp) }}" class="input-field @error('whatsapp') border-red-500 @enderror">
                    @error('whatsapp')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $settings->email) }}" class="input-field @error('email') border-red-500 @enderror">
                @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="facebook" class="mb-2 block text-sm font-medium text-gray-700">Facebook URL</label>
                    <input type="url" name="facebook" id="facebook" value="{{ old('facebook', $settings->facebook) }}" class="input-field @error('facebook') border-red-500 @enderror" placeholder="https://facebook.com/...">
                    @error('facebook')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="instagram" class="mb-2 block text-sm font-medium text-gray-700">Instagram URL</label>
                    <input type="url" name="instagram" id="instagram" value="{{ old('instagram', $settings->instagram) }}" class="input-field @error('instagram') border-red-500 @enderror" placeholder="https://instagram.com/...">
                    @error('instagram')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="about_us" class="mb-2 block text-sm font-medium text-gray-700">About Us</label>
                <textarea name="about_us" id="about_us" rows="5" class="input-field @error('about_us') border-red-500 @enderror">{{ old('about_us', $settings->about_us) }}</textarea>
                @error('about_us')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="shipping_policy" class="mb-2 block text-sm font-medium text-gray-700">Shipping Policy</label>
                <textarea name="shipping_policy" id="shipping_policy" rows="5" class="input-field @error('shipping_policy') border-red-500 @enderror">{{ old('shipping_policy', $settings->shipping_policy) }}</textarea>
                @error('shipping_policy')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mt-8">
            <button type="submit" class="btn-primary">Save Settings</button>
        </div>
    </form>
@endsection
