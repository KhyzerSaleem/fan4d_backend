<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDesign extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'file',
    ];


    public function getFileAttribute($image)
    {
        if (!empty($image) && file_exists(public_path('storage/cart_designs/' . $image))) {
            return asset('storage') . '/cart_designs/' . $image;
        }
        return asset('storage/default.png');
    }

    public function setFileAttribute($image)
    {
        if (!empty($image)) {
            $imageFields = $image;
            if (is_file($image)) {
                $imageFields = upload($image,'cart_designs');
            }
            $this->attributes['file'] = $imageFields;
        }
    }
}
