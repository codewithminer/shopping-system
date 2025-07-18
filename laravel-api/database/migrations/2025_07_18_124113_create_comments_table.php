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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            // Foreign key to the users table (who wrote the comment).
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // Foreign key to the products table (what is being commented on).
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            
            // The actual text content of the comment/review.
            $table->text('body');
            
            // An optional rating, e.g., 1 to 5 stars.
            $table->unsignedTinyInteger('rating')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
