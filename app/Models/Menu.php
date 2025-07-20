<?php

namespace App\Models;

use App\Enums\MenuType;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Menu
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $href
 * @property int $parent_id
 * @property int $status
 * @property int $position
 */
class Menu extends Model
{
    protected $casts = [
        'type' => MenuType::class,
    ];
    public $guarded = [];
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
        return $this->children()->with('childrenRecursive')->select('title', 'id', 'parent_id', 'status','position')->orderBy('position');
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
