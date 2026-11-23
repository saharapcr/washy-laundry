<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laundry_orders', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('kode')->unique();
            $t->unsignedInteger('total_harga')->default(0);
            $t->date('tanggal_pesanan');
            $t->dateTime('estimasi_selesai')->nullable();
            $t->string('status_pesanan')->default('Diterima');
            $t->dateTime('jadwal_jemput')->nullable();
            $t->text('alamat_jemput')->nullable();
            $t->text('catatan')->nullable();
            $t->string('kurir')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void
    {Schema::dropIfExists('laundry_orders');}
};
