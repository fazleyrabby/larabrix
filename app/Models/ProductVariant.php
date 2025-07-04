<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    // Each variant belongs to a single product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Each variant has many attribute values (like Color=Red, Size=XL)
    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_variant_values', 'variant_id', 'attribute_value_id');
    }
}
