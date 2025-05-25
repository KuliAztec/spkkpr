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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nik', 16)->unique();
            $table->string('email')->unique();
            $table->string('telepon', 15);
            $table->text('alamat');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->enum('status_pernikahan', ['belum_menikah', 'menikah', 'cerai']);
            $table->string('pekerjaan');
            $table->decimal('penghasilan_pribadi', 15, 2);
            $table->decimal('penghasilan_pasangan', 15, 2)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
