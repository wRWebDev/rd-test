<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Warehouse;

class ItemTest extends TestCase
{
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()->create();
        $warehouses = Warehouse::factory(2)->create();

        $this->product->warehouses()->syncWithPivotValues($warehouses, [
            'quantity' => 10,
            'threshold' => 2,
        ]);
    }
}
