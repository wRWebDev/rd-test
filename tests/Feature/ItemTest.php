<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Product;
use App\Models\Warehouse;
use App\Enums\OrderStatus;

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

    /**
     * A product can display its total stock across warehouses
     */
    public function test_products_total_quantity(): void
    {
        $this->assertEquals(20, $this->product->totalQuantity());
    }

    /**
     * A product can display its total stock allocated to orders
     */
    public function test_products_allocated_to_orders(): void
    {
        $order = Order::factory()->create(['status' => OrderStatus::PLACED]);

        $order->addProduct($this->product, 5);

        $this->assertEquals(5, $this->product->allocatedToOrders());
    }

    /**
     * A product can display its physical quantity
     * (sum of total quantity + what's allocated to orders)
     */
    public function test_products_physical_quantity(): void
    {
        $order = Order::factory()->create(['status' => OrderStatus::PLACED]);

        $order->addProduct($this->product, 5);

        $this->assertEquals(20, $this->product->physicalQuantity());
    }

    /**
     * A product can display its total threshold accross warehouses
     */
    public function test_products_total_threshold(): void
    {
        $this->assertEquals(4, $this->product->totalThreshold());
    }

    /**
     * A product can show its immediate despatch
     * (sum of total quantity - total threshold)
     */
    public function test_products_immediate_despatch(): void
    {
        $this->assertEquals(16, $this->product->immediateDespatch());
    }
}
