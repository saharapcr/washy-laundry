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
    Schema::create('payments', function (Blueprint $t) {
        $t->id();
        $t->foreignId('laundry_order_id')->constrained('laundry_orders')->cascadeOnDelete();
        $t->unsignedInteger('jumlah_bayar');
        $t->string('metode_pembayaran')->default('Tunai');
        $t->string('status_pembayaran')->default('Menunggu');
        $t->date('tanggal_pembayaran')->nullable();
        $t->timestamps();
    });
}
public function down(): void { Schema::dropIfExists('payments');
 }
};
