<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    public $guarded = [];

    protected $casts = [
        'builder' => 'array',
        // 'content' => MarkdownCast::class,
    ];

 

    public function scopeFilter($query, $searchQuery)
    {
        if ($searchQuery) {
            $query->where(function ($subQuery) use ($searchQuery) {
                $subQuery->where('title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('id', 'like', '%' . $searchQuery . '%');
            });
        }
        return $query;
    }
}
