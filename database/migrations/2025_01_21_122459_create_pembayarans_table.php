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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('id_jamaah')->nullable()->constrained('jamaah')->onDelete('cascade');
            $table->unsignedBigInteger('id_jamaah');
            $table->foreign('id_jamaah')->references('id')->on('jamaahs')->onDelete('cascade')->onUpdate('cascade')->default(1);
            $table->date('tanggal_pembayaran');
            $table->integer('jumlah_pembayaran');
            $table->string('keterangan');
            $table->string('penerima');
            $table->string('bukti_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
