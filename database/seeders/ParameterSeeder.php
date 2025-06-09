<?php

namespace Database\Seeders;

use App\Models\Parameter;
use App\Models\Subcriteria;
use Illuminate\Database\Seeder;

class ParameterSeeder extends Seeder
{
    public function run()
    {
        // Data parameter untuk setiap sub kriteria dengan nilai dimulai dari 50 dan turun 10 setiap urutan
        $parametersData = [
            // Character
            'Checking BI' => [
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

            'Loyalitas Nasabah' => [
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

            'Karakter' => [
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

            'Performa Kredit Sebelumnya' => [
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

            'Hutang Berjalan Pemohon' => [
                ['parameter_name' => '< 5 Juta', 'description' => 'Total hutang kurang dari 5 juta', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => '5 - 20 Juta', 'description' => 'Total hutang antara 5-20 juta', 'nilai' => 40, 'urutan' => 2],
                ['parameter_name' => '20 - 50 Juta', 'description' => 'Total hutang antara 20-50 juta', 'nilai' => 30, 'urutan' => 3],
                ['parameter_name' => '> 50 Juta', 'description' => 'Total hutang lebih dari 50 juta', 'nilai' => 20, 'urutan' => 4],
            ],

            'Tabungan Pemohon' => [
                ['parameter_name' => '> 50 Juta', 'description' => 'Tabungan lebih dari 50 juta', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => '40 - 50 Juta', 'description' => 'Tabungan antara 40-50 juta', 'nilai' => 40, 'urutan' => 2],
                ['parameter_name' => '20 - 40 Juta', 'description' => 'Tabungan antara 20-40 juta', 'nilai' => 30, 'urutan' => 3],
                ['parameter_name' => '< 20 Juta', 'description' => 'Tabungan kurang dari 20 juta', 'nilai' => 20, 'urutan' => 4],
            ],

            // Collateral
            'Nilai Properti' => [
                ['parameter_name' => '> 600 Juta', 'description' => 'Nilai properti lebih dari 600 juta', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => '400 - 600 Juta', 'description' => 'Nilai properti antara 400-600 juta', 'nilai' => 40, 'urutan' => 2],
                ['parameter_name' => '200 - 400 Juta', 'description' => 'Nilai properti antara 200-400 juta', 'nilai' => 30, 'urutan' => 3],
                ['parameter_name' => '< 200 Juta', 'description' => 'Nilai properti kurang dari 200 juta', 'nilai' => 20, 'urutan' => 4],
            ],

            'Kualitas Properti' => [
                ['parameter_name' => 'Sangat Baik', 'description' => 'Kualitas properti sangat baik', 'nilai' => 50, 'urutan' => 1],
                ['parameter_name' => 'Baik', 'description' => 'Kualitas properti baik', 'nilai' => 40, 'urutan' => 2],
                ['parameter_name' => 'Cukup', 'description' => 'Kualitas properti cukup', 'nilai' => 30, 'urutan' => 3],
                ['parameter_name' => 'Kurang', 'description' => 'Kualitas properti kurang', 'nilai' => 20, 'urutan' => 4],
            ],

            // Condition
            'Jangka Waktu Kredit' => [
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

        foreach ($parametersData as $subcriteriaName => $parameters) {
            $subcriteria = Subcriteria::where('name', $subcriteriaName)->first();
            
            if ($subcriteria) {
                foreach ($parameters as $paramData) {
                    Parameter::create([
                        'subcriteria_id' => $subcriteria->id,
                        'parameter_name' => $paramData['parameter_name'],
                        'description' => $paramData['description'],
                        'nilai' => $paramData['nilai'],
                        'urutan' => $paramData['urutan']
                    ]);
                }
            }
        }
    }
}
