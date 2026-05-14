<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pasien');
            $table->string('no_rm')->unique();
            $table->enum('kelas_bpjs', ['Kelas 1', 'Kelas 2', 'Kelas 3', 'Non-BPJS']);
            $table->text('diagnosis');
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar')->nullable();
            $table->foreignId('dpjp_id')->constrained('users')->onDelete('restrict');
            $table->string('ruangan')->nullable();
            $table->enum('status', ['aktif', 'pulang'])->default('aktif');
            $table->integer('los_final')->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
