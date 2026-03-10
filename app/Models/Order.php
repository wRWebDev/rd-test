<?php

namespace App\Models;

use Exception;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $uuid
 * @property OrderStatus $status
 * @property int $total
 */
class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    use HasUlids;

    /** @var string */
    protected $primaryKey = 'uuid';

    /** @var array<string> */
    protected $guarded = [];

    /** @return array<string> */
    public function uniqueIds()
    {
        return [
            'uuid',
        ];
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
        ];
    }

    /**
     * @return BelongsToMany<Product, $this>
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'orders_items')
            ->withPivot('price', 'quantity', 'total')
            ->withTimestamps();
    }

    public function addProduct(Product $product, int $quantity = 1, bool $updateTotal = true, bool $save = true): void
    {
        $this->products()->syncWithPivotValues(
            $product,
            values: [
                'price' => $product->price,
                'quantity' => $quantity,
                'total' => $product->price * $quantity,
            ],
            detaching: false
        );

        $quantityForOrder = $quantity;

        $product->warehousesOrderedByStockDesc()
            ->each(function (Warehouse $warehouse) use (&$quantityForOrder) {
                // Find the available stock from this warehouse
                $stock = $warehouse->stock->quantity - $warehouse->stock->threshold;

                // How much stock should we use from this warehouse?
                $fromWarehouse = $quantityForOrder > $stock
                    ? $stock
                    : $quantityForOrder;

                // Remove the stock from the warehouse
                $warehouse->stock->quantity -= $fromWarehouse;
                $warehouse->stock->save();

                $quantityForOrder -= $fromWarehouse;

                // If we've satisfied the order, break out of the each loop
                if ($quantityForOrder === 0) {
                    return;
                }
            });

        $product->forgetStats();

        if ($updateTotal) {
            $this->total += ($product->price * $quantity);
        }

        if ($save) {
            $this->save();
        }

        if ($quantityForOrder) {
            throw new Exception('There was not enough stock to satisfy this order');
        }
    }
}
