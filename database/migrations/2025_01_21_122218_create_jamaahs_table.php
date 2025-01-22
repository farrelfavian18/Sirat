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
        Schema::create('jamaahs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_paket');
            $table->foreign('id_paket')->references('id')->on('pakets')->onDelete('cascade')->onUpdate('cascade')->default(1);
            $table->unsignedBigInteger('id_perusahaan');
            $table->foreign('id_perusahaan')->references('id')->on('perusahaans')->onDelete('cascade')->onUpdate('cascade')->default(1);
            // $table->unsignedBigInteger('id_user');
            // $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade')->default(1);
            $table->string('nama_jamaah')->nullable();
            $table->string('alamat')->nullable();
            $table->string('kartu_keluarga')->nullable();
            $table->string('ktp')->nullable();
            $table->integer('no_telpon')->nullable();
            $table->string('surat_kesehatan')->nullable();
            $table->string('visa')->nullable();
            $table->string('surat_pendukung')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jamaahs');
    }
};
