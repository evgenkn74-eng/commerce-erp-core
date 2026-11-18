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
		Schema::create('customer_reviews', function (Blueprint $table) {
			$table->id();
			$table->string('external_id', 64)->unique();
			$table->foreignId('product_id')->constrained()->cascadeOnDelete();
			$table->unsignedTinyInteger('rating');
			$table->text('text');
			$table->string('status', 20)->default('new');
			$table->text('ai_draft')->nullable();
			$table->dateTime('answered_at')->nullable();
			$table->dateTime('created_at')->nullable();
			$table->dateTime('updated_at')->nullable();

			$table->index(['status', 'rating', 'created_at'], 'idx_reviews_queue');
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_reviews');
    }
};
