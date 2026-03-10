<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('warehouse_stock', function (Blueprint $table) {
            $table->foreignUlid('warehouse_uuid');
            $table->foreignUlid('product_uuid');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('threshold');
            $table->timestamps();

            $table->unique([
                'warehouse_uuid',
                'product_uuid',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_stock_pivot');
    }
};
