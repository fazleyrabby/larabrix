<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    public $guarded = [];   
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    public function transaction(): HasOne{
        return $this->hasOne(Transaction::class, 'order_id', 'id');
    }
}
