<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING     = 'pending';      // Order placed, awaiting confirmation
    case CONFIRMED   = 'confirmed';    // Payment confirmed
    case PROCESSING  = 'processing';   // Preparing items
    case COMPLETED   = 'completed';    // Order successfully fulfilled
    case CANCELLED   = 'cancelled';    // Cancelled before shipping
    case REFUNDED    = 'refunded';     // Payment refunded
}