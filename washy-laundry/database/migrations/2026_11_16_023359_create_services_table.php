<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $t) {
            $t->id();
            $t->string('nama_layanan');
            $t->text('deskripsi')->nullable();
            $t->unsignedInteger('harga_perkg');
            $t->unsignedTinyInteger('durasi_hari')->default(2);
            $t->boolean('status_layanan')->default(true);
            $t->timestamps();
        });
    }
    public function down(): void
    {Schema::dropIfExists('services');}
};
