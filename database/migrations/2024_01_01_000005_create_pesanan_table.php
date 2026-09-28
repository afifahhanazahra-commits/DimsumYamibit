<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->string('kode_pesanan', 20)->unique();
            $table->foreignId('id_pelanggan')->constrained('pelanggan', 'id_pelanggan')->onDelete('cascade');
            $table->dateTime('tanggal_pesanan')->useCurrent();
            $table->enum('metode_pengiriman', ['pickup', 'ojol']);
            $table->string('bukti_qris', 255)->nullable();
            $table->enum('status_pembayaran', ['menunggu', 'valid', 'ditolak'])->default('menunggu');
            $table->enum('status_pesanan', ['menunggu_bayar', 'diproses', 'siap_diambil', 'selesai'])->default('menunggu_bayar');
            $table->integer('total_harga')->default(0);
            $table->text('link_wa')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};