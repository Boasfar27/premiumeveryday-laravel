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
        Schema::dropIfExists('digital_product_licenses');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('digital_product_licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('digital_product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->string('license_key')->unique();
            $table->enum('status', ['available', 'assigned', 'activated', 'expired'])->default('available');
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->unsignedInteger('max_activations')->default(1);
            $table->unsignedInteger('activation_count')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
};
