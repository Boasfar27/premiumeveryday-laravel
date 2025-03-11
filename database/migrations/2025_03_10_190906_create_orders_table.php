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
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('whatsapp', 20);
            $table->string('product_name', 100);
            $table->enum('subscription_type', ['sharing', 'private']);
            $table->decimal('amount', 10, 2);
            $table->binary('payment_proof')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->string('coupon_code', 50)->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('final_amount', 10, 2);
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
