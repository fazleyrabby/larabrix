<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive')->select('title', 'id', 'parent_id', 'status')->orderBy('position');
    }
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $searchableFields = ['title', 'id'];
            foreach ($searchableFields as $field) {
                $q->orWhere($field, 'like', "%{$term}%");
            }
        });
    }
}
