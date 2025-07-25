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
        Schema::create('nilai_topsis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_barang_id')->constrained('pengajuan_barang')->onDelete('cascade');
            $table->foreignId('kriteria_topsis_id')->constrained('kriteria_topsis')->onDelete('cascade');
            $table->float('nilai');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_topsis');
    }
};
