<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
             // Foreign key to the orders table.
             $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
             // Foreign key to the products table. Assumes products table exists.
             $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
             
             // How many of the product were ordered.
             $table->unsignedInteger('quantity');
             
             // The price of a single item at the time of purchase.
             $table->decimal('price_at_purchase', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
