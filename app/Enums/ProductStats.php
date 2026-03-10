<?php

namespace App\Enums;

enum ProductStats: string
{
    case TOTAL_QUANTITY = 'total';
    case ALLOCATED_TO_ORDERS = 'allocated';
    case PHYSICAL_QUANTITY = 'physical';
    case THRESHOLD = 'threshold';
    case IMMEDIATE_DESPATCH = 'immediate';
}
