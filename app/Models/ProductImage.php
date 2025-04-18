<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $fillable =[ 'product_id', 'image' ];


    public function getImageAttribute($image)
    {
        if (!empty($image) && file_exists(public_path('storage/products/' . $image))) {
            return asset('storage') . '/products/' . $image;
        }
        return asset('storage/default.png');
    }

    public function setImageAttribute($image)
    {
        if (!empty($image)) {
            $imageFields = $image;
            if (is_file($image)) {
                $imageFields = upload($image,'products');
            }
            $this->attributes['image'] = $imageFields;
        }
    }
}
