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
            $table->string('whatsapp', 20)->nullable();
            $table->string('product_name', 100)->default('Unknown Product');
            $table->enum('subscription_type', ['sharing', 'private'])->default('sharing');
            $table->decimal('amount', 10, 2)->default(0);
            $table->binary('payment_proof')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('coupon_code', 50)->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable()->default(0);
            $table->decimal('final_amount', 10, 2)->default(0);
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
