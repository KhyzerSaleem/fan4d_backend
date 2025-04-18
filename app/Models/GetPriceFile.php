<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GetPriceFile extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable =
        [
            'get_price_id',
            'file'
        ];

    public function getFileAttribute($image)
    {
        if (!empty($image) && file_exists(public_path('storage/get_price/' . $image))) {
            return asset('storage') . '/get_price/' . $image;
        }
        return asset('storage/default.png');
    }

    public function setFileAttribute($image)
    {
        if (!empty($image)) {
            $imageFields = $image;
            if (is_file($image)) {
                $imageFields = upload($image, 'get_price');
            }
            $this->attributes['file'] = $imageFields;
        }
    }
}
