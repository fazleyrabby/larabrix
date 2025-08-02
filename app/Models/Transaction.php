<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $guarded = [];
    
    public function order()
    {
        return $this->hasOne(Order::class);
    }

}
