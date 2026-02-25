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
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('session_id')->nullable(); // For guest users
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_charge', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('total', 10, 2);
            
            // Payment Info
           $table->string('payment_method'); 

            $table->string('transaction_id')->nullable();
            $table->string('payment_status')->default('pending'); // pending, paid, failed
            $table->string('bkash_mobile')->nullable();
            $table->string('bkash_transaction_id')->nullable();
            $table->string('order_status')->default('pending'); // pending, processing, shipped, delivered, cancelled
            
            // Shipping Details
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->string('city');
            $table->string('postal_code');
            $table->text('order_notes')->nullable();
            $table->timestamps();
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
