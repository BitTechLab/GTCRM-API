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
        Schema::create('customer_prices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->decimal('discount_percentage')->nullable();
            $table->decimal('discount_amount')->nullable();

            $table->timestamps();

            $table->softDeletes();

            $table->index(['customer_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_prices');
    }
};
