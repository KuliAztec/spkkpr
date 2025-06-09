<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('report_alternatives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluation_report_id')->constrained()->onDelete('cascade');
            $table->foreignId('alternative_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('code');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->decimal('final_score', 8, 6)->default(0);
            $table->integer('rank')->default(0);
            $table->json('evaluations_data')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('report_alternatives');
    }
};
