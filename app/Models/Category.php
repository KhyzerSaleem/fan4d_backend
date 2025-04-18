<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title_ar',
        'title_en',
        'desc_ar',
        'type',
        'desc_en',
        'is_active',
    ];
    const TYPE = ['printing', 'not_printing'];

    protected $appends = ['title', 'description'];

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

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }

    public function getImageAttribute($image)
    {
        if (!empty($image) && file_exists(public_path('storage/categories/' . $image))) {
            return asset('storage') . '/categories/' . $image;
        }
        return asset('storage/default.png');
    }

    public function setImageAttribute($image)
    {
        if (!empty($image)) {
            $imageFields = $image;
            if (is_file($image)) {
                $imageFields = upload($image, 'categories');
            }
            $this->attributes['image'] = $imageFields;
        }
    }
}
