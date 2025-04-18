<?php

namespace App\Models;

use Laratrust\Models\Permission as PermissionModel;

class Permission extends PermissionModel
{
    public $guarded = [
        'name',
        'display_name_ar',
        'display_name_en',
        'model',
        'description',
    ];

    protected $appends = ['display_name'];

    public function getDisplayNameAttribute()
    {
        if (\app()->getLocale() == "en") {
            return $this->display_name_en;
        } else {
            return $this->display_name_ar;
        }
    }
}
