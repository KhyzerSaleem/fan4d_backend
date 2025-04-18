<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'desc_ar',
        'desc_en',
        'type',
    ];

    const TYPE = ['about', 'terms', 'privacy'];

    protected $appends = ['description'];

    public function getDescriptionAttribute()
    {
        if (\app()->getLocale() == "en") {
            return $this->desc_en;
        } else {
            return $this->desc_ar;
        }
    }

    public function getImageAttribute($image)
    {
        if (!empty($image) && file_exists(public_path('storage/' . $image))) {
            return asset('storage') . '/' . $image;
        }
        return asset('storage/default.png');
    }

    public function setImageAttribute($image)
    {
        if (!empty($image)) {
            $imageFields = $image;
            if (is_file($image)) {
                $imageFields = upload($image);
            }
            $this->attributes['image'] = $imageFields;
        }
    }
}
