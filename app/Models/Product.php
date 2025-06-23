<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function scopeFilter($query, $searchQuery)
    {
        if ($searchQuery) {
            $query->where(function ($subQuery) use ($searchQuery) {
                $subQuery->where('title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%')
                    ->orWhere('id', 'like', '%' . $searchQuery . '%');
            })->orWhereHas('category', function ($q) use ($searchQuery) {
                $q->where('title', 'like', '%' . $searchQuery . '%');
            });
        }

        return $query;
    }

    public function getShortDescriptionAttribute()
    {
        return str()->limit($this->description, 20, '...');
    }

    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
