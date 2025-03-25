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
        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'price')) {
                $table->decimal('price', 10, 2)->after('quantity')->nullable();
            }
            
            if (!Schema::hasColumn('order_items', 'subscription_type')) {
                $table->string('subscription_type')->nullable()->after('total');
            }
            
            if (!Schema::hasColumn('order_items', 'duration')) {
                $table->integer('duration')->nullable()->after('subscription_type');
            }
            
            if (!Schema::hasColumn('order_items', 'account_type')) {
                $table->string('account_type')->nullable()->after('duration');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['price', 'subscription_type', 'duration', 'account_type']);
        });
    }
};
