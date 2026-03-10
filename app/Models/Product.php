<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $uuid
 * @property string $title
 * @property string $description
 * @property int $price - (in pence)
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

    /** @return BelongsToMany<Warehouse, $this> */
    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class, 'warehouse_stock')
            ->withPivot('quantity', 'threshold')
            ->withTimestamps();
    }
}
