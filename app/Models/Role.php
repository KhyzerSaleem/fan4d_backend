<?php

namespace App\Models;

use Laratrust\Models\Role as RoleModel;

class Role extends RoleModel
{
    public $fillable = [
        'name',
        'display_name_ar',
        'display_name_en',
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
