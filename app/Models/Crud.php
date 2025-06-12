<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crud extends Model
{
    use HasFactory;
    public $guarded = [];

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
