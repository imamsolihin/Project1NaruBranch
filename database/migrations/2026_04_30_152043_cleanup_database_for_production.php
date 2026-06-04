<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * CATATAN: Perintah delete data telah dinonaktifkan karena berbahaya
     * pada deployment ke database baru (menghapus seluruh data produksi).
     */
    public function up(): void
    {
        // Sengaja dikosongkan - jangan hapus file ini agar tidak dijalankan ulang
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
