<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_plan_id',
        'invoice_id',
        'invoice_url',
        'price',
        'is_completed',
        'type',
    ];

    public function user_plan()
    {
        return $this->belongsTo(UserPlan::class, 'user_plan_id');
    }
}
