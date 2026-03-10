<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class WarehouseStock extends Pivot
{
    public function subtractQuantity(int $toSubtract): void
    {
        $this->quantity -= $toSubtract;
        $this->save();
    }

    public function availableQuantity(): int
    {
        return $this->quantity - $this->threshold;
    }
}
