<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok', function (Blueprint $table) {
            $table->id('id_stok');
            $table->foreignId('id_menu')->unique()->constrained('menu', 'id_menu')->onDelete('cascade');
            $table->integer('jumlah_stok')->default(0);
            $table->timestamp('update_terakhir')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok');
    }
};