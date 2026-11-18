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
		Schema::create('sales_daily', function (Blueprint $table) {
			$table->id();
			$table->foreignId('product_id')->constrained()->cascadeOnDelete();
			$table->date('sale_date');
			$table->unsignedInteger('quantity');
			$table->decimal('amount', 12, 2);

			$table->unique(['product_id', 'sale_date'], 'uq_sales_product_date');
			// $table->index(['sale_date', 'product_id'], 'idx_sale_date_product');
			$table->index(['sale_date', 'product_id', 'quantity'], 'idx_sale_date_product_qty');
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_dailies');
    }
};
