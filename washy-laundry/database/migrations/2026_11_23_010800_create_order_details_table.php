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
    Schema::create('order_details', function (Blueprint $t) {
        $t->id();
        $t->foreignId('laundry_order_id')->constrained('laundry_orders')->cascadeOnDelete();
        $t->foreignId('service_id')->constrained('services');
        $t->decimal('berat_kg', 8, 2);
        $t->unsignedInteger('harga_perkg');
        $t->unsignedInteger('subtotal');
        $t->timestamps();
    });
}
public function down(): void { Schema::dropIfExists('order_details'); 
    }
};
