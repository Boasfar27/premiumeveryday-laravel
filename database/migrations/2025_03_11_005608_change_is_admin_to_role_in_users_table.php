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
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom is_admin
            $table->dropColumn('is_admin');
            
            // Tambah kolom role (0 = user, 1 = admin)
            $table->tinyInteger('role')->default(0)->after('email_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom role
            $table->dropColumn('role');
            
            // Kembalikan kolom is_admin
            $table->boolean('is_admin')->default(false)->after('email_verified_at');
        });
    }
};
