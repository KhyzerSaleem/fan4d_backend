<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'user_id',
        'type',
        'title_ar',
        'title_en',
        'desc_en',
        'desc_ar',
        'code',
        'start_date',
        'expire_date',
        'user_use_count',
        'min_order_price',
        'is_active',
        'use_count',
        'voucher_used_count',
        'for_first_order',
        'percent',
        'amount',
    ];

    protected $appends = ['title', 'description'];

    const TYPE = ['general', 'points_reward'];

    const points_reward = "points_reward";

    public function getTitleAttribute()
    {
        if (\app()->getLocale() == "en") {
            return $this->title_en;
        } else {
            return $this->title_ar;
        }
    }

    public function getDescriptionAttribute()
    {
        if (\app()->getLocale() == "en") {
            return $this->desc_en;
        } else {
            return $this->desc_ar;
        }
    }

    public function getImageAttribute($image)
    {
        if (!empty($image) && file_exists(public_path('storage/vouchers/' . $image))) {
            return asset('storage') . '/vouchers/' . $image;
        }
        return asset('storage/default.png');
    }

    public function setImageAttribute($image)
    {
        if (!empty($image)) {
            $imageFields = $image;
            if (is_file($image)) {
                $imageFields = upload($image, 'vouchers');
            }
            $this->attributes['image'] = $imageFields;
        }
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }

    public function users()
    {
        return $this->hasMany(VoucherUser::class, 'voucher_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
