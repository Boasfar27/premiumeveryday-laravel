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
        Schema::table('digital_products', function (Blueprint $table) {
            $table->string('product_type')->default('Digital Product')->change();
        });
        
        // Update existing records with null product_type
        DB::table('digital_products')
            ->whereNull('product_type')
            ->update(['product_type' => 'Digital Product']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('digital_products', function (Blueprint $table) {
            $table->string('product_type')->nullable()->change();
        });
    }
}; 