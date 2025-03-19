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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            }
            
            if (!Schema::hasColumn('orders', 'order_number')) {
                $table->string('order_number')->nullable()->after('id');
            }
            
            if (!Schema::hasColumn('orders', 'order_type')) {
                $table->enum('order_type', ['digital_product', 'subscription'])->default('digital_product')->after('user_id');
            }
            
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending')->after('status');
            }
            
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->enum('payment_method', ['bank_transfer', 'midtrans', 'manual'])->default('midtrans')->after('payment_status');
            }
            
            if (!Schema::hasColumn('orders', 'payment_methods')) {
                $table->text('payment_methods')->nullable()->after('payment_method');
            }
            
            if (!Schema::hasColumn('orders', 'midtrans_url')) {
                $table->string('midtrans_url')->nullable()->after('payment_methods');
            }
            
            if (!Schema::hasColumn('orders', 'midtrans_token')) {
                $table->string('midtrans_token')->nullable()->after('midtrans_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = [
                'user_id',
                'order_number',
                'order_type',
                'payment_status',
                'payment_method',
                'payment_methods',
                'midtrans_url',
                'midtrans_token',
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
