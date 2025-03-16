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
        Schema::create('digital_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('features')->nullable(); // JSON or HTML content of features
            $table->text('requirements')->nullable(); // System requirements if applicable
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->boolean('is_on_sale')->default(false);
            $table->timestamp('sale_ends_at')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('gallery')->nullable(); // Array of image URLs
            $table->string('demo_url')->nullable(); // URL to demo if available
            $table->string('download_url')->nullable(); // URL to download file if direct download
            $table->bigInteger('download_count')->default(0);
            $table->string('version')->nullable(); // Software version if applicable
            $table->enum('product_type', ['software', 'ebook', 'audio', 'video', 'premium_account', 'other'])->default('premium_account');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_products');
    }
};
