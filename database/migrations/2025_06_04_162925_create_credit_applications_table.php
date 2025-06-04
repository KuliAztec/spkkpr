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
        Schema::create('credit_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            
            // Basic loan information
            $table->decimal('loan_amount', 15, 2);
            $table->string('loan_purpose');
            $table->integer('loan_term'); // in months
            $table->enum('status', ['pending', 'approved', 'rejected', 'under_review'])->default('pending');
            $table->date('application_date');
            $table->text('notes')->nullable();
            
            // Character criteria
            $table->foreignId('bi_checking_parameter_id')->nullable()->constrained('sub_criteria_parameters');
            $table->foreignId('prestasi_pekerjaan_parameter_id')->nullable()->constrained('sub_criteria_parameters');
            $table->foreignId('loyalitas_parameter_id')->nullable()->constrained('sub_criteria_parameters');
            $table->foreignId('usia_parameter_id')->nullable()->constrained('sub_criteria_parameters');
            $table->foreignId('sikap_parameter_id')->nullable()->constrained('sub_criteria_parameters');
            
            // Capacity criteria
            $table->foreignId('penghasilan_pribadi_parameter_id')->nullable()->constrained('sub_criteria_parameters');
            $table->foreignId('penghasilan_pasangan_parameter_id')->nullable()->constrained('sub_criteria_parameters');
            $table->foreignId('performa_kredit_parameter_id')->nullable()->constrained('sub_criteria_parameters');
            
            // Capital criteria
            $table->foreignId('pekerjaan_parameter_id')->nullable()->constrained('sub_criteria_parameters');
            $table->foreignId('hutang_parameter_id')->nullable()->constrained('sub_criteria_parameters');
            $table->foreignId('tabungan_parameter_id')->nullable()->constrained('sub_criteria_parameters');
            
            // Collateral criteria (using same as capital for now)
            $table->foreignId('collateral_pekerjaan_parameter_id')->nullable()->constrained('sub_criteria_parameters');
            $table->foreignId('collateral_hutang_parameter_id')->nullable()->constrained('sub_criteria_parameters');
            $table->foreignId('collateral_tabungan_parameter_id')->nullable()->constrained('sub_criteria_parameters');
            
            // Condition criteria
            $table->foreignId('jangka_waktu_parameter_id')->nullable()->constrained('sub_criteria_parameters');
            $table->foreignId('suku_bunga_parameter_id')->nullable()->constrained('sub_criteria_parameters');
            $table->foreignId('inflasi_parameter_id')->nullable()->constrained('sub_criteria_parameters');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_applications');
    }
};
