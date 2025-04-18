<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Splash extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title_ar',
        'title_en',
        'desc_en',
        'desc_ar',
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

    public function getImageAttribute($image)
    {
        if (!empty($image) && file_exists(public_path('storage/splashes/' . $image))) {
            return asset('storage') . '/splashes/' . $image;
        }
        return asset('storage/default.png');
    }

    public function setImageAttribute($image)
    {
        if (!empty($image)) {
            $imageFields = $image;
            if (is_file($image)) {
                $imageFields = upload($image,'splashes');
            }
            $this->attributes['image'] = $imageFields;
        }
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }
}
