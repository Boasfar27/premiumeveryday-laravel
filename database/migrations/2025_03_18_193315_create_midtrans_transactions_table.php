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
        Schema::create('midtrans_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('transaction_id')->nullable();
            $table->string('payment_type')->nullable();
            $table->decimal('gross_amount', 12, 2);
            $table->dateTime('transaction_time')->nullable();
            $table->string('transaction_status')->default('pending');
            $table->json('va_numbers')->nullable();
            $table->string('fraud_status')->nullable();
            $table->string('payment_code')->nullable();
            $table->string('pdf_url')->nullable();
            $table->string('status_code')->nullable();
            $table->text('status_message')->nullable();
            $table->string('snap_token')->nullable();
            $table->text('redirect_url')->nullable();
            $table->dateTime('expiry_time')->nullable();
            $table->json('payment_methods')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('midtrans_transactions');
    }
};
