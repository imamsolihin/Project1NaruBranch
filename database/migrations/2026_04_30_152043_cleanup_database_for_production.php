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
        // Hapus semua project
        \Illuminate\Support\Facades\DB::table('projects')->delete();

        // Hapus semua user kecuali admin
        \Illuminate\Support\Facades\DB::table('users')->where('role', '!=', 'admin')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
