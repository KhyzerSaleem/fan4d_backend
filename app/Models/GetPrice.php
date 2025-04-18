<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GetPrice extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'user_id',
            'subject',
            'message',
            'reply',
            'seen_at'
        ];


    public function files(): HasMany
    {
        return $this->hasMany(GetPriceFile::class, 'get_price_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
