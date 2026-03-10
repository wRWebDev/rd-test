<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $uuid
 * @property string $name
 * @property string $slug
 * @property string $geo_location
 * @property string $address_1
 * @property string $address_2
 * @property string $town
 * @property string $county
 * @property string $postcode
 * @property string $state_code
 * @property string $country_code
 * @property-read WarehouseStock $stock
 */
class Warehouse extends Model
{
    /** @use HasFactory<\Database\Factories\WarehouseFactory> */
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

    /** @return BelongsToMany<Product, $this, WarehouseStock, 'stock'> */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'warehouse_stock')
            ->using(WarehouseStock::class)
            ->as('stock')
            ->withPivot('quantity', 'threshold')
            ->withTimestamps();
    }

    public function getMapsLink(): string
    {
        return sprintf('https://maps.google.com?q=%s', $this->geo_location);
    }
}
