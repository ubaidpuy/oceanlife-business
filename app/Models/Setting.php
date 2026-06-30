<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_name',
        'logo',
        'address',
        'phone',
        'whatsapp',
        'email',
        'facebook',
        'instagram',
        'about_us',
        'shipping_policy',
    ];

    public static function instance(): self
    {
        return static::firstOrCreate([], [
            'shop_name' => 'Ocean Life',
        ]);
    }

    public static function clearCache(): void
    {
        // Reserved for future cache invalidation
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? Storage::url($this->logo) : null;
    }
}
