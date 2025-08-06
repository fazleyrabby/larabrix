<?php 
namespace App\Traits;

trait Searchable
{
    public function scopeSearch($query, ?string $term)
    {
        if (!$term || !property_exists($this, 'searchable') || empty($this->searchable)) {
            return $query;
        }
        
        return $query->where(function ($q) use ($term) {
            foreach ($this->searchable as $field) {
                $q->orWhere($field, 'like', "%{$term}%");
            }
        });
    }
}