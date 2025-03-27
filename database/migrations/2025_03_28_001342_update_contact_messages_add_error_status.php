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
        // First, modify the enum to include 'error' status
        DB::statement("ALTER TABLE contact_messages MODIFY status ENUM('pending', 'read', 'replied', 'error') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE contact_messages MODIFY status ENUM('pending', 'read', 'replied') DEFAULT 'pending'");
    }
};
