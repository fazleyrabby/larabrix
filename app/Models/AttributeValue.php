<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'attribute_id'];
    // Each value belongs to one attribute (e.g., "Red" belongs to "Color")
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    // Many variants can have this attribute value
    public function variants()
    {
        return $this->belongsToMany(ProductVariant::class, 'product_variant_values', 'attribute_value_id', 'product_variant_id');
    }
     
}
