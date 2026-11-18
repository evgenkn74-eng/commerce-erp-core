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
		Schema::create('integration_logs', function (Blueprint $table) {
			$table->id();
			$table->string('service', 50);
			$table->string('endpoint');
			$table->unsignedSmallInteger('status_code')->nullable();
			$table->unsignedInteger('duration_ms')->nullable();
			$table->text('error')->nullable();
			$table->dateTime('created_at')->useCurrent();

			$table->index(['service', 'created_at']);
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integration_logs');
    }
};
