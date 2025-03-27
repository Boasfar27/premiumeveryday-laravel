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
        // Lepaskan foreign key terlebih dahulu
        Schema::table('orders', function (Blueprint $table) {
            // Cek apakah foreign key ada sebelum mencoba drop
            if (Schema::hasColumn('orders', 'product_id')) {
                $table->dropForeign(['product_id']);
                // Kolom tetap ada, tidak perlu diubah
            }
        });

        // Hapus tabel products
        Schema::dropIfExists('products');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Buat kembali tabel products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->decimal('sharing_price', 10, 2);
            $table->decimal('private_price', 10, 2);
            $table->decimal('price', 10, 2);
            $table->text('sharing_description')->nullable();
            $table->text('private_description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
        
        // Buat kembali foreign key di orders table jika kolom masih ada
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'product_id')) {
                $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();
            }
        });
    }
};
