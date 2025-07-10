<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'body', 'slug', 'is_published'];

    public function terms()
    {
        return $this->belongsToMany(Term::class);
    }

    public function tags()
    {
        return $this->terms()->where('type', 'tag');
    }
}
