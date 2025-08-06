<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use Searchable;
    protected array $searchable = [
        'id',
        'order_number',
        'payment_gateway',
    ];
    public $guarded = [];   
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    public function transaction(): HasOne{
        return $this->hasOne(Transaction::class, 'order_id', 'id');
    }
}
