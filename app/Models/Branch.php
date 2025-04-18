<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title_ar',
        'title_en',
        'desc_en',
        'desc_ar',
        'lat',
        'lng',
        'address_ar',
        'address_en',
        'is_active',
    ];


    protected $appends = ['title','description','address'];

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

    public function getAddressAttribute(){
        if (\app()->getLocale() == "en") {
            return $this->address_en;
        } else {
            return $this->address_ar;
        }
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }

    public function getImageAttribute($image)
    {
        if (!empty($image) && file_exists(public_path('storage/branches/' . $image))) {
            return asset('storage') . '/branches/' . $image;
        }
        return asset('storage/default.png');
    }

    public function setImageAttribute($image)
    {
        if (!empty($image)) {
            $imageFields = $image;
            if (is_file($image)) {
                $imageFields = upload($image,'branches');
            }
            $this->attributes['image'] = $imageFields;
        }
    }

    public function images()
    {
        return $this->hasMany(BranchImage::class);
    }


}
