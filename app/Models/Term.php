<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $fillable = ['type', 'value', 'slug'];
    public function blogs()
    {
        return $this->belongsToMany(Blog::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scope to get only tags
    public function scopeTags($query)
    {
        return $query->where('type', 'tag');
    }

    public function scopeFilter($query, $searchQuery, $type)
    {
        if ($searchQuery) {
            $query->where('type', $type)
            ->where('value', 'like', '%' . $searchQuery . '%');
        }

        return $query;
    }
}
