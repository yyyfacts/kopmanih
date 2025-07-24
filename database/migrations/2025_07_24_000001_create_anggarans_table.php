<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_anggaran');
            $table->decimal('jumlah', 20, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->date('tanggal')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggarans');
    }
};
