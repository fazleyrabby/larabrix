<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductVariant extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $guarded = [];
    // Each variant belongs to a single product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Each variant has many attribute values (like Color=Red, Size=XL)
    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_variant_values', 'product_variant_id', 'attribute_value_id');
    }

    public function getFullImageAttribute()
    {
        return $this->image ? ((Str::startsWith($this->image, ['http://', 'https://']) ? $this->image : Storage::disk('public')->url($this->image))) : '';
    }
}
