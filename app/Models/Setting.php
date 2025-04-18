<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'image',
    ];

    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            if (file_exists(public_path('storage/' . $image))) {
                return asset('storage') . '/' . $image;
            }
            return asset('storage/default.png');
        }
        return null;
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
