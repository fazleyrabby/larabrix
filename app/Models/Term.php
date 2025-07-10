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

    // Scope to get only tags
    public function scopeTags($query)
    {
        return $query->where('type', 'tag');
    }
}
