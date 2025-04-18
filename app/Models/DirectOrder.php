<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectOrder extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'name',
            'email',
            'phone',
            'subject',
            'message',
            'reply',
            'seen_at'
        ];


    public function files()
    {
        return $this->hasMany(DirectOrderFile::class, 'direct_order_id', 'id');
    }
}
