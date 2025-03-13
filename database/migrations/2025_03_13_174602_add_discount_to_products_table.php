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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('sharing_discount')->default(0);
            $table->integer('private_discount')->default(0);
            $table->boolean('is_promo')->default(false);
            $table->timestamp('promo_ends_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sharing_discount', 'private_discount', 'is_promo', 'promo_ends_at']);
        });
    }
};
