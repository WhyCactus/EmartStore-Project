<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('return_code')->unique();
            $table->text('return_reason');
            $table->enum('return_status', ['requested', 'approved', 'rejected', 'processing', 'completed'])->default('requested');
            $table->text('admin_note')->nullable();
            $table->dateTime('requested_at');
            $table->dateTime('processed_at')->nullable();
            $table->timestamps();

            $table->index(['order_id', 'return_code', 'return_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_returns');
    }
};
