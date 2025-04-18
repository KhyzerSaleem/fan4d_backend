<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title_ar',
        'title_en',
        'category_id',
        'desc_ar',
        'desc_en',
        'price',
        'image',
        'have_discount',
        'discount',
        'is_active',
        'custom_quantity_from',
        'custom_quantity_to',
    ];

    protected $appends = ['title', 'description', 'price_original'];

    public function getPriceOriginalAttribute()
    {
        return $this->attributes['price'];
    }

    public function getPriceAttribute()
    {
        $price = $this->attributes['price'];
        if ($this->discount > 0) {
            $discount_amount = $price * ($this->discount / 100);
            $price = $price - $discount_amount;
        }
        return $price;
    }

    public function getTitleAttribute()
    {
        if (\app()->getLocale() == "en") {
            return $this->title_en;
        } else {
            return $this->title_ar;
        }
    }

    public function getDescriptionAttribute()
    {
        if (\app()->getLocale() == "en") {
            return $this->desc_en;
        } else {
            return $this->desc_ar;
        }
    }

    public function getImageAttribute($image): string
    {
        if (!empty($image) && file_exists(public_path('storage/products/' . $image))) {
            return asset('storage') . '/products/' . $image;
        }
        return asset('storage/default.png');
    }

    public function setImageAttribute($image): void
    {
        if (!empty($image)) {
            $imageFields = $image;
            if (is_file($image)) {
                $imageFields = upload($image, 'products');
            }
            $this->attributes['image'] = $imageFields;
        }
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category(): belongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function quantities(): HasMany
    {
        return $this->hasMany(ProductQuantity::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function attributes_with_options(): HasMany
    {
        return $this->hasMany(ProductAttribute::class)->whereHas('options');
    }

    public function scopeActive($query): void
    {
        $query->where('is_active', 1);
    }

}
