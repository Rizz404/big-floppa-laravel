<?php

use App\Models\Order;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('order_id')->constrained('orders')->restrictOnDelete();
            $table->string('payment_method', 100);
            $table->string('external_transaction_id', 100)->nullable();
            $table->decimal('amount', 12, 2);
            $table->enum('status', [
                'pending',
                'settlement',
                'expire',
                'cancel',
                'deny'
            ])->nullable()->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
