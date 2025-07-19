<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    public $guarded = [];
    public function folder()
    {
        return $this->belongsTo(MediaFolder::class, 'folder_id');
    }
}
