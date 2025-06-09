<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('evaluation_reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->datetime('calculation_date');
            $table->integer('total_alternatives');
            $table->integer('total_criteria');
            $table->integer('total_subcriteria');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('evaluation_reports');
    }
};
