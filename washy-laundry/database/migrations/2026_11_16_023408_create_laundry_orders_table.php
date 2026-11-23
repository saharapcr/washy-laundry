<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laundry_orders', function (Blueprint $table) {
            $table->id();

            $table->string('invoice_number')->unique();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('service_id')
                ->constrained()
                ->restrictOnDelete();

            $table->decimal('weight', 8, 2);
            $table->decimal('price_per_kg', 12, 2);
            $table->decimal('total_price', 12, 2);

            $table->string('status')->default('menunggu');
            $table->string('payment_status')->default('belum_bayar');

            $table->text('notes')->nullable();

            $table->timestamp('received_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('picked_up_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laundry_orders');
    }
};
