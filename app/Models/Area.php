<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'title_ar',
        'title_en',
        'cost',
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
}
