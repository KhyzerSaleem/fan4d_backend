<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeOption extends Model
{
    use HasFactory;

    protected $fillable = ['product_attribute_id',
        'title_ar',
        'title_en',
        'image',
        'price',
    ];

    protected $appends = ['title'];

    public function getTitleAttribute()
    {
        if (\app()->getLocale() == "en") {
            return $this->title_en;
        } else {
            return $this->title_ar;
        }
    }

    public function product_attribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id');
    }

    public function getImageAttribute($image): string
    {
        if (!empty($image) && file_exists(public_path('storage/options/' . $image))) {
            return asset('storage') . '/options/' . $image;
        }
        return asset('storage/default.png');
    }

    public function setImageAttribute($image): void
    {
        if (!empty($image)) {
            $imageFields = $image;
            if (is_file($image)) {
                $imageFields = upload($image, 'options');
            }
            $this->attributes['image'] = $imageFields;
        }
    }


}
