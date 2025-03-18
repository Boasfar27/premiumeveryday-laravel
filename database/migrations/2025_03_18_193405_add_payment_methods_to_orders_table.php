<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add order_number column if it doesn't exist
            if (!Schema::hasColumn('orders', 'order_number')) {
                $table->string('order_number')->nullable()->after('id');
            }
            
            // Add Midtrans specific columns if they don't exist
            if (!Schema::hasColumn('orders', 'payment_methods')) {
                $table->text('payment_methods')->nullable()->after('payment_status');
            }
            
            if (!Schema::hasColumn('orders', 'midtrans_url')) {
                $table->string('midtrans_url')->nullable()->after('payment_methods');
            }
            
            if (!Schema::hasColumn('orders', 'midtrans_token')) {
                $table->string('midtrans_token')->nullable()->after('midtrans_url');
            }
            
            // Make sure user_id exists (may have been missing in original migration)
            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id');
            }
        });
        
        // Update existing columns to be nullable using raw SQL to avoid requiring doctrine/dbal
        DB::statement('ALTER TABLE orders MODIFY product_name VARCHAR(100) NULL DEFAULT "Unknown Product"');
        DB::statement('ALTER TABLE orders MODIFY subscription_type ENUM("sharing", "private", "monthly", "quarterly", "semiannual", "annual") NULL DEFAULT "sharing"');
        DB::statement('ALTER TABLE orders MODIFY amount DECIMAL(10,2) NULL DEFAULT 0');
        DB::statement('ALTER TABLE orders MODIFY final_amount DECIMAL(10,2) NULL DEFAULT 0');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'order_number')) {
                $table->dropColumn('order_number');
            }
            
            if (Schema::hasColumn('orders', 'payment_methods')) {
                $table->dropColumn('payment_methods');
            }
            
            if (Schema::hasColumn('orders', 'midtrans_url')) {
                $table->dropColumn('midtrans_url');
            }
            
            if (Schema::hasColumn('orders', 'midtrans_token')) {
                $table->dropColumn('midtrans_token');
            }
        });
    }
};
