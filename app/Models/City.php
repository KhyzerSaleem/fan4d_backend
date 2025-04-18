<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'is_active',
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


    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }

    public function areas()
    {
        return $this->hasMany(Area::class, 'city_id');
    }

}
