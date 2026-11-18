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
			// синтаксический сахар Laravel, который разворачивается в BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
			$table->id();
			// foreignId() создаёт колонку для внешнего ключа; обычно это UNSIGNED BIGINT
			// constrained() создаёт внешний ключ на соответствующую таблицу и колонку (categories.id - имя сам воссоздает по имени колонки)
			$table->foreignId('category_id')->constrained()->restrictOnDelete();
			$table->string('sku', 64)->unique();
			// Длина не указана — по умолчанию VARCHAR(255)
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
