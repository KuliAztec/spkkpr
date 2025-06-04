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
        Schema::create('sub_criteria_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_criteria_id')->constrained()->onDelete('cascade');
            $table->string('parameter_name');
            $table->text('description')->nullable();
            $table->decimal('nilai', 8, 2);
            $table->integer('urutan')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_criteria_parameters');
    }
};
