<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'namespace',
        'config',
        'enabled',
    ];

    protected $casts = [
        'config' => 'array',
        'enabled' => 'boolean',
    ];

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $searchableFields = ['name', 'id'];
            foreach ($searchableFields as $field) {
                $q->orWhere($field, 'like', "%{$term}%");
            }
        });
    }
}
