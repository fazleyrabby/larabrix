<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = ['name', 'slug', 'fields'];

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }
    public function formFields()
    {
        return $this->hasMany(FormField::class, 'form_id', 'id')->orderBy('order');
    }
}
