<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Product;

class OrderObserver
{
    /**
     * Handle the Order "updating" event.
     */
    public function updating(Order $order): void
    {
        if ($order->isDirty('status')) {
            $order->products()->each(fn (Product $product) => $product->forgetStats());
        }
    }
}
