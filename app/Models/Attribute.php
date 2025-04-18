<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'type',
        'is_active',];

    protected $appends = ['title'];

    const TYPE = ['text', 'text with image'];

    public function getTitleAttribute()
    {
        if (\app()->getLocale() == "en") {
            return $this->title_en;
        } else {
            return $this->title_ar;
        }
    }

    public function options(): HasMany
    {
        return $this->hasMany(AttributeOption::class, 'attribute_id');
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }

}
