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
        // Drop and recreate the column with all needed statuses
        DB::statement("ALTER TABLE contact_messages MODIFY COLUMN status ENUM('pending', 'read', 'replied', 'error', 'sent') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original state
        DB::statement("ALTER TABLE contact_messages MODIFY COLUMN status ENUM('pending', 'read', 'replied') NOT NULL DEFAULT 'pending'");
    }
};
