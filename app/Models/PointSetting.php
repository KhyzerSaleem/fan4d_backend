<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'description',
        'points',
        'is_active',
    ];


    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }
}
