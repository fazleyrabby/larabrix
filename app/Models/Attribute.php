<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    public $guarded = [];
    // An attribute has many values
    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    // Many products can have this attribute (many-to-many)
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attributes');
    }

    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
