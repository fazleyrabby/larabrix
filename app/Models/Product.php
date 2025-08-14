<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    public $guarded = [];

    // Product has many variants
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Product belongs to many attributes
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attributes');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function scopeFilter($query, $searchQuery)
    {
        if ($searchQuery) {
            $query->where(function ($subQuery) use ($searchQuery) {
                $subQuery->where('title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('sku', 'like', '%' . $searchQuery . '%')
                    ->orWhere('id', 'like', '%' . $searchQuery . '%');
            })->orWhereHas('category', function ($q) use ($searchQuery) {
                $q->where('title', 'like', '%' . $searchQuery . '%');
            });
        }

        return $query;
    }

    // public function getShortDescriptionAttribute()
    // {
    //     return str()->limit($this->description, 20);
    // }

    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getAttributesAttribute()
    {
        return $this->variants->flatMap->attributeValues->map->attribute->pluck('title')->unique()->join(' / ') ?: '';
    }

    public function getFullImageAttribute(){
        return $this->image ? asset($this->image) : 'https://placehold.co/400';
    }
}
