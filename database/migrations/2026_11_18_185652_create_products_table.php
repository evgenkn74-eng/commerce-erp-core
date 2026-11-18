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
		Schema::create('products', function (Blueprint $table) {
			$table->id();
			$table->foreignId('category_id')->constrained()->restrictOnDelete();
			$table->string('sku', 64)->unique();
			$table->string('name');
			$table->decimal('price', 10, 2);
			$table->dateTime('created_at')->nullable();
			$table->dateTime('updated_at')->nullable();

			$table->index('category_id');
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
