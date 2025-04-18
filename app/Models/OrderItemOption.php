<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'product_attribute_option_id',
        'price',
    ];

    public function orderItem(){
        return $this->belongsTo(OrderItem::class);
    }
    public function productAttributeOption(){
        return $this->belongsTo(ProductAttributeOption::class);
    }


}
