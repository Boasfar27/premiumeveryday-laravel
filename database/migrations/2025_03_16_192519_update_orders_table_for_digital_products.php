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
        // Check if columns exist before adding them
        $columns = Schema::getColumnListing('orders');

        Schema::table('orders', function (Blueprint $table) use ($columns) {
            // Add new columns if they don't exist
            if (!in_array('order_type', $columns)) {
                $table->enum('order_type', ['digital_product', 'subscription'])->after('user_id')->default('digital_product');
            }
            
            if (!in_array('subtotal', $columns)) {
                $table->decimal('subtotal', 10, 2)->after('order_type')->default(0);
            }
            
            if (!in_array('tax', $columns)) {
                $table->decimal('tax', 10, 2)->default(0)->after('subtotal');
            }
            
            if (!in_array('shipping', $columns)) {
                $table->decimal('shipping', 10, 2)->default(0)->after('tax');
            }
            
            if (!in_array('total', $columns)) {
                $table->decimal('total', 10, 2)->after('discount_amount')->default(0);
            }
            
            if (!in_array('payment_method', $columns)) {
                $table->enum('payment_method', ['bank_transfer', 'paypal', 'credit_card', 'other'])->default('bank_transfer')->after('total');
            }
            
            if (!in_array('payment_status', $columns)) {
                $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending')->after('payment_method');
            }
            
            if (!in_array('paid_at', $columns)) {
                $table->timestamp('paid_at')->nullable()->after('payment_status');
            }
            
            if (!in_array('billing_details', $columns)) {
                $table->json('billing_details')->nullable()->after('paid_at');
            }
            
            if (!in_array('customer_notes', $columns)) {
                $table->text('customer_notes')->nullable()->after('billing_details');
            }
            
            if (!in_array('admin_notes', $columns)) {
                $table->text('admin_notes')->nullable()->after('customer_notes');
            }
        });

        // Create order items table if it doesn't exist
        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained()->onDelete('cascade');
                $table->morphs('orderable'); // For digital_product or subscription_plan
                $table->string('name')->nullable(); // Make name field nullable
                $table->integer('quantity')->default(1);
                $table->decimal('unit_price', 10, 2);
                $table->decimal('subtotal', 10, 2);
                $table->decimal('discount', 10, 2)->default(0);
                $table->decimal('tax', 10, 2)->default(0);
                $table->decimal('total', 10, 2);
                $table->json('options')->nullable(); // Additional options like license type, etc.
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');

        Schema::table('orders', function (Blueprint $table) {
            // Drop columns if they exist
            $columns = Schema::getColumnListing('orders');
            
            $columnsToDrop = [
                'order_type',
                'subtotal',
                'tax',
                'shipping',
                'total',
                'payment_method',
                'payment_status',
                'paid_at',
                'billing_details',
                'customer_notes',
                'admin_notes',
            ];
            
            $existingColumns = array_intersect($columnsToDrop, $columns);
            
            if (!empty($existingColumns)) {
                $table->dropColumn($existingColumns);
            }
        });
    }
};
