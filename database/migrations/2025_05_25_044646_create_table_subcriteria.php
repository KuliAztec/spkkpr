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
        Schema::create('sub_criterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_id')->constrained('criterias')->onDelete('cascade');
            $table->string('kode', 10);
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->decimal('bobot', 5, 4)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['criteria_id', 'kode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_criterias');
    }
};
