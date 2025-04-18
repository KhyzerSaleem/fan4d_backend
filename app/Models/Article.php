<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'desc_ar',
        'desc_en',
        'image',
        'published_at',
        'is_active',
    ];

    protected $appends = ['title','description'];

    public function getTitleAttribute()
    {
        if (\app()->getLocale() == "en") {
            return $this->title_en;
        } else {
            return $this->title_ar;
        }
    }
    public function getDescriptionAttribute(){
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
        if (!empty($image) && file_exists(public_path('storage/articles/' . $image))) {
            return asset('storage') . '/articles/' . $image;
        }
        return asset('storage/default.png');
    }

    public function setImageAttribute($image)
    {
        if (!empty($image)) {
            $imageFields = $image;
            if (is_file($image)) {
                $imageFields = upload($image,'articles');
            }
            $this->attributes['image'] = $imageFields;
        }
    }

}
