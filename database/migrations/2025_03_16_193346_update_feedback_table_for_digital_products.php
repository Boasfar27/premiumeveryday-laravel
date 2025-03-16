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
        Schema::table('feedback', function (Blueprint $table) {
            // Check if product_id exists before dropping it
            if (Schema::hasColumn('feedback', 'product_id')) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            }
            
            // Add new columns if they don't exist
            if (!Schema::hasColumn('feedback', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('rating')->constrained()->nullOnDelete();
            }
            
            if (!Schema::hasColumn('feedback', 'feedbackable_id')) {
                $table->unsignedBigInteger('feedbackable_id')->nullable()->after('user_id');
                $table->string('feedbackable_type')->nullable()->after('feedbackable_id');
            }
            
            if (!Schema::hasColumn('feedback', 'email')) {
                $table->string('email')->nullable()->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            // Drop new columns if they exist
            $columns = ['user_id', 'feedbackable_id', 'feedbackable_type', 'email'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('feedback', $column)) {
                    if ($column === 'user_id') {
                        $table->dropForeign(['user_id']);
                    }
                    $table->dropColumn($column);
                }
            }
            
            // Restore original column if it doesn't exist
            if (!Schema::hasColumn('feedback', 'product_id')) {
                $table->foreignId('product_id')->nullable()->after('rating');
            }
        });
    }
};
