<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id',
        'product_id',
        'count',
        'quantity',
        'price',];

    public function designs(): HasMany
    {
        return $this->hasMany(OrderItemDesign::class, 'order_item_id');
    }

    public function options(): HasMany
    {
        return $this->hasMany(OrderItemOption::class, 'order_item_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
