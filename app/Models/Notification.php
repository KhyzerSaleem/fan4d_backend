<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'desc_ar',
        'desc_en',
        'type',
        'user_type',
        'users',
        'action',
        'target_id',
        'target_type',
    ];


    const ANDROID = 'android';
    const IOS = 'ios';
    const ACTIONS = [
        'general',
        'change_status',
        'manual_send',
    ];

    const TYPE = ['general', 'reservation'];

    const USER_TYPE = ['all', 'custom'];

    protected $appends = ['title','desc'];

    public function getTitleAttribute()
    {
        if (\app()->getLocale() == "en") {
            return $this->title_en;
        } else {
            return $this->title_ar;
        }
    } public function getDescAttribute()
    {
        if (\app()->getLocale() == "en") {
            return $this->desc_en;
        } else {
            return $this->desc_ar;
        }
    }
}
