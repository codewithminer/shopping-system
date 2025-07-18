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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
             // Foreign key to the orders table.
             $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            
             // The unique transaction ID from the payment gateway (e.g., Stripe).
             // It's nullable in case we want to record a payment attempt before a transaction ID is generated.
             $table->string('transaction_id')->nullable()->unique();
             
             // The amount that was paid.
             $table->decimal('amount', 8, 2);
             
             // The status of the payment transaction.
             $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
             
             // Storing additional details from the gateway as JSON.
             $table->json('payment_gateway_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
