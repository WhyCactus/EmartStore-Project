<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('product_code')->unique();
            $table->string('image', 500)->nullable();
            $table->text('description')->nullable();
            $table->decimal('original_price', 15, 2);
            $table->decimal('discounted_price', 15, 2)->nullable();
            $table->enum('status', ['active', 'inactive', 'out_of_stock'])->default('active');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->integer('quantity_in_stock')->default(0);
            $table->integer('sold_count')->default(0);
            $table->timestamps();

            $table->index(['category_id', 'status']);
            $table->index('product_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
