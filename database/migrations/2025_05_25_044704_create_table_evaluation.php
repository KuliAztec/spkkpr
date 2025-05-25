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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('evaluator_id')->constrained('users');
            $table->decimal('total_score', 6, 4)->default(0);
            $table->integer('ranking')->nullable();
            $table->enum('recommendation', ['approved', 'rejected', 'review'])->default('review');
            $table->enum('status', ['pending', 'completed', 'approved', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('evaluated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
