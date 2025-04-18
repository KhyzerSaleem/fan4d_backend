<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'desc_ar',
        'desc_en',
        'image',
        'plan_id',
        'url',
        'type',
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
        if (!empty($image) && file_exists(public_path('storage/sliders/' . $image))) {
            return asset('storage') . '/sliders/' . $image;
        }
        return asset('storage/default.png');
    }

    public function setImageAttribute($image)
    {
        if (!empty($image)) {
            $imageFields = $image;
            if (is_file($image)) {
                $imageFields = upload($image,'sliders');
            }
            $this->attributes['image'] = $imageFields;
        }
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }

    public function package()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

}
