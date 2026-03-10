<?php

namespace Database\Seeders;

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
                    'quantity' => fake()->numberBetween(10, 50),
                    'threshold' => fake()->numberBetween(1, 10),
                ]);
            }
        }
    }
}
