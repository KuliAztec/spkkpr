<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubCriteria;
use App\Models\SubCriteriaParameter;

class SubCriteriaParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua sub kriteria
        $subCriterias = SubCriteria::all();

        // Data parameter untuk setiap sub kriteria dengan nilai dimulai dari 50 dan turun 10 setiap urutan
        $parametersData = [
            // Character
            'BI Checking' => [
                ['parameter_name' => 'Kredit Lancar', 'description' => 'Kredit dalam kondisi lancar', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => 'Kredit Dalam Perhatian', 'description' => 'Kredit dalam perhatian khusus', 'nilai' => 40, 'urutan' => 2],
                ['parameter_name' => 'Kredit Diragukan', 'description' => 'Kredit dalam kondisi diragukan', 'nilai' => 30, 'urutan' => 3],
                ['parameter_name' => 'Kredit Tidak Lancar', 'description' => 'Kredit dalam kondisi tidak lancar', 'nilai' => 20, 'urutan' => 4],
                ['parameter_name' => 'Kredit Macet', 'description' => 'Kredit dalam kondisi macet', 'nilai' => 10, 'urutan' => 5],
            ],

            'Prestasi Pekerjaan' => [
                ['parameter_name' => 'Sangat Baik', 'description' => 'Prestasi pekerjaan sangat baik', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => 'Baik', 'description' => 'Prestasi pekerjaan baik', 'nilai' => 40, 'urutan' => 2],
                ['parameter_name' => 'Cukup', 'description' => 'Prestasi pekerjaan cukup', 'nilai' => 30, 'urutan' => 3],
                ['parameter_name' => 'Kurang', 'description' => 'Prestasi pekerjaan kurang', 'nilai' => 20, 'urutan' => 4],
            ],

            'Loyalitas (Frekuensi)' => [
                ['parameter_name' => 'Selalu', 'description' => 'Selalu menunjukkan loyalitas', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => 'Sering', 'description' => 'Sering menunjukkan loyalitas', 'nilai' => 40, 'urutan' => 2],
                ['parameter_name' => 'Kadang', 'description' => 'Kadang menunjukkan loyalitas', 'nilai' => 30, 'urutan' => 3],
                ['parameter_name' => 'Jarang', 'description' => 'Jarang menunjukkan loyalitas', 'nilai' => 20, 'urutan' => 4],
            ],

            'Usia' => [
                ['parameter_name' => '21 - 30', 'description' => 'Usia antara 21 hingga 30 tahun', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => '31 - 39', 'description' => 'Usia antara 31 hingga 39 tahun', 'nilai' => 40, 'urutan' => 2],
                ['parameter_name' => '40 - 49', 'description' => 'Usia antara 40 hingga 49 tahun', 'nilai' => 30, 'urutan' => 3],
                ['parameter_name' => '>= 50', 'description' => 'Usia 50 tahun ke atas', 'nilai' => 20, 'urutan' => 4],
            ],

            'Sikap' => [
                ['parameter_name' => 'Sangat Baik', 'description' => 'Sikap sangat baik', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => 'Baik', 'description' => 'Sikap baik', 'nilai' => 40, 'urutan' => 2],
                ['parameter_name' => 'Cukup', 'description' => 'Sikap cukup', 'nilai' => 30, 'urutan' => 3],
                ['parameter_name' => 'Kurang', 'description' => 'Sikap kurang', 'nilai' => 20, 'urutan' => 4],
            ],

            // Capacity
            'Penghasilan Pribadi' => [
                ['parameter_name' => '> 10 Juta', 'description' => 'Penghasilan pribadi lebih dari 10 juta', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => '6-10 Juta', 'description' => 'Penghasilan pribadi antara 6-10 juta', 'nilai' => 40, 'urutan' => 2],
                ['parameter_name' => '3-5 Juta', 'description' => 'Penghasilan pribadi antara 3-5 juta', 'nilai' => 30, 'urutan' => 3],
                ['parameter_name' => '< 3 Juta', 'description' => 'Penghasilan pribadi kurang dari 3 juta', 'nilai' => 20, 'urutan' => 4],
            ],

            'Penghasilan Pasangan' => [
                ['parameter_name' => '> 10 Juta', 'description' => 'Penghasilan pasangan lebih dari 10 juta', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => '6-10 Juta', 'description' => 'Penghasilan pasangan antara 6-10 juta', 'nilai' => 40, 'urutan' => 2],
                ['parameter_name' => '3-5 Juta', 'description' => 'Penghasilan pasangan antara 3-5 juta', 'nilai' => 30, 'urutan' => 3],
                ['parameter_name' => '< 3 Juta', 'description' => 'Penghasilan pasangan kurang dari 3 juta', 'nilai' => 20, 'urutan' => 4],
            ],

            'Performa Kredit' => [
                ['parameter_name' => 'Kredit Lancar', 'description' => 'Performa kredit lancar', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => 'Kredit Dalam Perhatian', 'description' => 'Performa kredit dalam perhatian', 'nilai' => 40, 'urutan' => 2],
                ['parameter_name' => 'Kredit Diragukan', 'description' => 'Performa kredit diragukan', 'nilai' => 30, 'urutan' => 3],
                ['parameter_name' => 'Kredit Tidak Lancar', 'description' => 'Performa kredit tidak lancar', 'nilai' => 20, 'urutan' => 4],
                ['parameter_name' => 'Kredit Macet', 'description' => 'Performa kredit macet', 'nilai' => 10, 'urutan' => 5],
            ],

            // Capital
            'Pekerjaan' => [
                ['parameter_name' => 'Pegawai Tetap', 'description' => 'Status pegawai tetap', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => 'Wiraswasta/Pengusaha', 'description' => 'Status wiraswasta atau pengusaha', 'nilai' => 40, 'urutan' => 2],
                ['parameter_name' => 'Pekerja Lepas', 'description' => 'Status pekerja lepas', 'nilai' => 30, 'urutan' => 3],
            ],

            'Hutang' => [
                ['parameter_name' => '< 5 Juta', 'description' => 'Total hutang kurang dari 3 juta', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => '5 - 20 Juta', 'description' => 'Total hutang antara 3-6 juta', 'nilai' => 40, 'urutan' => 2],
                ['parameter_name' => '20 - 50 Juta', 'description' => 'Total hutang antara 6-15 juta', 'nilai' => 30, 'urutan' => 3],
                ['parameter_name' => '> 50 Juta', 'description' => 'Total hutang lebih dari 15 juta', 'nilai' => 20, 'urutan' => 4],
            ],

            'Tabungan' => [
                ['parameter_name' => '> 50 Juta', 'description' => 'Tabungan lebih dari 50 juta', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => '40 - 50 Juta', 'description' => 'Tabungan antara 40-50 juta', 'nilai' => 40, 'urutan' => 2],
                ['parameter_name' => '20 - 40 Juta', 'description' => 'Tabungan antara 20-40 juta', 'nilai' => 30, 'urutan' => 3],
                ['parameter_name' => '< 20 Juta', 'description' => 'Tabungan kurang dari 20 juta', 'nilai' => 20, 'urutan' => 4],
            ],

            // Collateral (menggunakan parameter yang sama dengan Capital)

            'Nilai Properti' => [
                ['parameter_name' => '> 600 Juta', 'description' => 'Nilai properti lebih dari 1 miliar', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => '400 - 600 Juta', 'description' => 'Nilai properti antara 500 juta hingga 1 miliar', 'nilai' => 40, 'urutan' => 2],
                ['parameter_name' => '200 - 400 Juta', 'description' => 'Nilai properti antara 200 juta hingga 500 juta', 'nilai' => 30, 'urutan' => 3],
                ['parameter_name' => '< 200 Juta', 'description' => 'Nilai properti kurang dari 200 juta', 'nilai' => 20, 'urutan' => 4],
            ],

            'Kualitas Properti' => [
                ['parameter_name' => 'Sangat Baik', 'description' => 'Kualitas properti sangat baik', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => 'Baik', 'description' => 'Kualitas properti baik', 'nilai' => 40, 'urutan' => 2],
                ['parameter_name' => 'Cukup', 'description' => 'Kualitas properti cukup', 'nilai' => 30, 'urutan' => 3],
                ['parameter_name' => 'Kurang', 'description' => 'Kualitas properti kurang', 'nilai' => 20, 'urutan' => 4],
            ],


            // Condition
            'Jangka Waktu' => [
                ['parameter_name' => '15 Tahun', 'description' => 'Jangka waktu kredit 15 tahun', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => '10 Tahun', 'description' => 'Jangka waktu kredit 10 tahun', 'nilai' => 40, 'urutan' => 2],
                ['parameter_name' => '5 Tahun', 'description' => 'Jangka waktu kredit 5 tahun', 'nilai' => 30, 'urutan' => 3],
            ],

            'Suku Bunga' => [
                ['parameter_name' => '11,25 Persen', 'description' => 'Suku bunga 11,25 persen', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => '8,75 Persen', 'description' => 'Suku bunga 8,75 persen', 'nilai' => 40, 'urutan' => 2],
            ],

            'Inflasi' => [
                ['parameter_name' => '< 2 Persen', 'description' => 'Tingkat inflasi kurang dari 2 persen', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => '< 5 Persen', 'description' => 'Tingkat inflasi kurang dari 5 persen', 'nilai' => 40, 'urutan' => 2],
                ['parameter_name' => '< 8 Persen', 'description' => 'Tingkat inflasi kurang dari 8 persen', 'nilai' => 30, 'urutan' => 3],
                ['parameter_name' => '> 8 Persen', 'description' => 'Tingkat inflasi lebih dari 8 persen', 'nilai' => 20, 'urutan' => 4],
            ],
        ];

        // Loop untuk setiap sub kriteria
        foreach ($subCriterias as $subCriteria) {
            // Cari parameter yang sesuai dengan nama sub kriteria
            $parameters = $parametersData[$subCriteria->nama] ?? [];
            
            // Jika tidak ada parameter yang sesuai, buat parameter default
            if (empty($parameters)) {
                $parameters = [
                    ['parameter_name' => 'Sangat Baik', 'description' => 'Kondisi sangat baik', 'nilai' => 50, 'urutan' => 1],
                    ['parameter_name' => 'Baik', 'description' => 'Kondisi baik', 'nilai' => 40, 'urutan' => 2],
                    ['parameter_name' => 'Cukup', 'description' => 'Kondisi cukup', 'nilai' => 30, 'urutan' => 3],
                    ['parameter_name' => 'Kurang', 'description' => 'Kondisi kurang', 'nilai' => 20, 'urutan' => 4],
                ];
            }

            // Cek apakah parameter sudah ada untuk sub kriteria ini
            $existingCount = SubCriteriaParameter::where('sub_criteria_id', $subCriteria->id)->count();
            
            if ($existingCount == 0) {
                // Insert parameter untuk sub kriteria ini
                foreach ($parameters as $parameterData) {
                    SubCriteriaParameter::create([
                        'sub_criteria_id' => $subCriteria->id,
                        'parameter_name' => $parameterData['parameter_name'],
                        'description' => $parameterData['description'],
                        'nilai' => $parameterData['nilai'],
                        'urutan' => $parameterData['urutan'],
                        'is_active' => true,
                    ]);
                }
                
                $this->command->info("Parameters created for sub criteria: {$subCriteria->nama}");
            } else {
                $this->command->info("Parameters already exist for sub criteria: {$subCriteria->nama}");
            }
        }

        $this->command->info('SubCriteriaParameter seeder completed successfully!');
    }
}
