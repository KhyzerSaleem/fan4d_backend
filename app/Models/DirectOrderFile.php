<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectOrderFile extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'direct_order_id',
            'file'
        ];

    public function getFileAttribute($image)
    {
        if (!empty($image) && file_exists(public_path('storage/direct_orders_files/' . $image))) {
            return asset('storage') . '/direct_orders_files/' . $image;
        }
        return asset('storage/default.png');
    }

    public function setFileAttribute($image)
    {
        if (!empty($image)) {
            $imageFields = $image;
            if (is_file($image)) {
                $imageFields = upload($image, 'direct_orders_files');
            }
            $this->attributes['file'] = $imageFields;
        }
    }
}
