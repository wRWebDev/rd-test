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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->ulid('uuid');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('geo_location');
            $table->string('address_1');
            $table->string('address_2');
            $table->string('town');
            $table->string('county');
            $table->string('postcode');
            $table->string('state_code');
            $table->string('country_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
