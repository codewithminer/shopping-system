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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Foreign key to the users table. Assumes users table exists.
            // constrained() automatically uses the 'id' column of the 'users' table.
            // cascadeOnDelete() will delete all orders of a user if that user is deleted.
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Using decimal for monetary values is best practice.
            // 8 digits in total, 2 after the decimal point.
            $table->decimal('total_price',8,2);
            // The status of the order.
            $table->enum('status',['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            // Storing addresses as JSON is flexible.
            $table->json('shipping_address');
            $table->json('billing_address');
            // The payment method used.
            $table->string('payment_method')->nullable();
            // The status of the payment.
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->timestamps();   // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
