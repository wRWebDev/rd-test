<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /** @var Collection<int, Product> $products */
        $products = Product::factory(10)->create();

        /** @var Collection<int, Warehouse> $warehouses */
        $warehouses = Warehouse::factory(10)->create();

        foreach ($products as $product) {
            foreach ($warehouses as $warehouse) {
                $warehouse->products()->attach($product->uuid, [
                    'quantity' => fake()->numberBetween(20, 50),
                    'threshold' => fake()->numberBetween(1, 10),
                ]);
            }
        }

        $order = Order::factory(5)->create(['total' => 0]);

        $order->each(function (Order $order) use ($products) {
            $product = $products->random();
            $quantity = fake()->numberBetween(1, $product->immediateDespatch());
            $order->addProduct($product, $quantity);
        });
    }
}
