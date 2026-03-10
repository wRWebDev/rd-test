<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $uuid
 * @property string $title
 * @property string $description
 * @property int $price - (in pence)
 * @property-read WarehouseStock $stock
 */
class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
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

    /** @return BelongsToMany<Warehouse, $this, WarehouseStock, 'stock'> */
    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class, 'warehouse_stock')
            ->using(WarehouseStock::class)
            ->as('stock')
            ->withPivot('quantity', 'threshold')
            ->withTimestamps();
    }

    /** @return BelongsToMany<Warehouse, $this, WarehouseStock, 'stock'> */
    public function warehousesOrderedByStockDesc(): BelongsToMany
    {
        return $this->warehouses()
            ->orderByPivotDesc('quantity');
    }

    /** @return BelongsToMany<Order, $this> */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'orders_items')
            ->withPivot('price', 'quantity', 'total')
            ->withTimestamps();
    }

    public function totalQuantity(): int
    {
        return $this->warehouses()->sum('warehouse_stock.quantity');
    }

    public function allocatedToOrders(): int
    {
        return $this->orders()
            ->where('status', OrderStatus::PLACED)
            ->sum('orders_items.quantity');
    }

    public function physicalQuantity(): int
    {
        return $this->totalQuantity() + $this->allocatedToOrders();
    }
}
