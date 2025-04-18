<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_attribute_option_id',
    ];

    public function option()
    {
        return $this->belongsTo(ProductAttributeOption::class, 'product_attribute_option_id');
    }

}
