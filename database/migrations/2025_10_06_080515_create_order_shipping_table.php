<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_shipping', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained()->onDelete('cascade');
            $table->string('shipping_method');
            $table->decimal('shipping_cost', 15, 2)->default(0);
            $table->string('tracking_number')->nullable();
            $table->enum('delivery_status', ['pending', 'shipped', 'in_transit', 'delivered', 'failed'])->default('pending');
            $table->date('estimated_delivery')->nullable();
            $table->dateTime('actual_delivery')->nullable();
            $table->text('delivery_notes')->nullable();
            $table->text('failed_reason')->nullable();
            $table->timestamps();

            $table->index(['order_id', 'tracking_number', 'delivery_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_shipping');
    }
};
