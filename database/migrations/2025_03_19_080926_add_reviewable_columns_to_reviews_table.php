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
        Schema::table('reviews', function (Blueprint $table) {
            // Tambahkan kolom polimorfik reviewable
            $table->string('reviewable_type')->nullable()->after('order_id');
            $table->unsignedBigInteger('reviewable_id')->nullable()->after('reviewable_type');
            
            // Tambahkan indeks untuk optimasi query
            $table->index(['reviewable_type', 'reviewable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Hapus indeks terlebih dahulu
            $table->dropIndex(['reviewable_type', 'reviewable_id']);
            
            // Hapus kolom
            $table->dropColumn(['reviewable_type', 'reviewable_id']);
        });
    }
};
