<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\ProductStats;
use App\Traits\HasCurrencyAttributes;
use Illuminate\Support\Facades\Cache;
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
 *
 * @use HasFactory<\Database\Factories\ProductFactory>
 */
class Product extends Model
{
    use HasCurrencyAttributes;
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
        return Cache::rememberForever(
            $this->getStatCacheKey(ProductStats::TOTAL_QUANTITY),
            fn () => $this->warehouses()->sum('warehouse_stock.quantity')
        );
    }

    public function allocatedToOrders(): int
    {
        return Cache::rememberForever(
            $this->getStatCacheKey(ProductStats::ALLOCATED_TO_ORDERS),
            fn () => $this->orders()
                ->where('status', OrderStatus::PLACED)
                ->sum('orders_items.quantity')
        );
    }

    public function physicalQuantity(): int
    {
        return Cache::rememberForever(
            $this->getStatCacheKey(ProductStats::PHYSICAL_QUANTITY),
            fn () => $this->totalQuantity() + $this->allocatedToOrders()
        );
    }

    public function totalThreshold(): int
    {
        return Cache::rememberForever(
            $this->getStatCacheKey(ProductStats::THRESHOLD),
            fn () => $this->warehouses()->sum('warehouse_stock.threshold')
        );
    }

    public function immediateDespatch(): int
    {
        return Cache::rememberForever(
            $this->getStatCacheKey(ProductStats::IMMEDIATE_DESPATCH),
            fn () => $this->totalQuantity() - $this->totalThreshold(),
        );
    }

    private function getStatCacheKey(ProductStats $stat): string
    {
        return sprintf('product:%s:%s', $this->uuid, $stat->value);
    }

    public function forgetStats(): void
    {
        foreach (ProductStats::cases() as $stat) {
            Cache::forget($this->getStatCacheKey($stat));
        }
    }
}
