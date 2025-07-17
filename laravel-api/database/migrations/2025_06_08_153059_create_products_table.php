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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->decimal('price',10,2);
            $table->decimal('sale_price',10,2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->string('sku')->nullable(); //sku means stock keeping unit
            $table->string('barcode')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->json('images')->nullable();
            $table->json('attributes')->nullable(); // store size, color, etc
            $table->decimal('weight',8,2)->nullable();
            $table->string('dimensions')->nullable(); // length x width x height
            $table->boolean('manage_stock')->default(true);
            $table->enum('stock_status',['instock','outofstock','onbackorder'])->default('instock');
            $table->integer('min_quantity')->default(1);
            $table->integer('sort_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('views_count')->default(0);
            $table->string('image')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_best_seller')->default(false);
            $table->timestamps();

            //Foreign key
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            //Index for better performance
            $table->index(['is_active', 'is_featured']);
            $table->index(['category_id', 'is_active']);
            $table->index('stock_status');
            $table->index('price');
            $table->fullText(['name', 'description']); // For search functionality
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
