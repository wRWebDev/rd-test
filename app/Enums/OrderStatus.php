<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PLACED = 'placed';
    case DISPATCHED = 'dispatched';
    case CANCELLED = 'cancelled';
}
