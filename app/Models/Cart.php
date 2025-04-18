<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id',
        'product_id',
        'count',
        'quantity',];

    protected $appends = ['price'];

    public function getPriceAttribute(){

        $price = $this->product->price;
        if (isset($this->options)) {
            foreach ($this->options as $key => $row) {
                $price += $row->option->price;
            }
        }
        $price = $price * $this->quantity;
        $price = $price * $this->count;
        return $price ;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function designs(): HasMany
    {
        return $this->hasMany(CartDesign::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(CartOption::class);
    }

}
