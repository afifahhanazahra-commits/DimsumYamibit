<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topping', function (Blueprint $table) {
            $table->id('id_topping');
            $table->string('nama_topping', 50);
            $table->integer('harga_tambahan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topping');
    }
};