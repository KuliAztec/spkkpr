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
        Schema::create('ahp_matrices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_id')->nullable()->constrained('criterias')->onDelete('cascade');
            $table->foreignId('sub_criteria_id')->nullable()->constrained('sub_criterias')->onDelete('cascade');
            $table->enum('comparison_type', ['criteria', 'sub_criteria']);
            $table->json('matrix_data');
            $table->json('weights');
            $table->decimal('consistency_ratio', 5, 4)->nullable();
            $table->boolean('is_valid')->default(false);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ahp_matrices');
    }
};
