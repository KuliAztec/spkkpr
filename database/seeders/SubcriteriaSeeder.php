<?php

namespace Database\Seeders;

use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Database\Seeder;

class SubCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subCriterias = [
            // Character (C1)
            'C1' => [
                ['kode' => 'C1.1', 'nama' => 'Checking BI', 'deskripsi' => 'Pemeriksaan riwayat kredit di Bank Indonesia'],
                ['kode' => 'C1.2', 'nama' => 'Usia', 'deskripsi' => 'Usia pemohon kredit'],
                ['kode' => 'C1.3', 'nama' => 'Prestasi Pekerjaan', 'deskripsi' => 'Pencapaian dan prestasi dalam pekerjaan'],
                ['kode' => 'C1.4', 'nama' => 'Karakter', 'deskripsi' => 'Penilaian kepribadian dan integritas'],
                ['kode' => 'C1.5', 'nama' => 'Loyalitas Nasabah', 'deskripsi' => 'Frekuensi transaksi dan loyalitas sebagai nasabah'],
            ],
            // Capacity (C2)
            'C2' => [
                ['kode' => 'C2.1', 'nama' => 'Penghasilan Pribadi', 'deskripsi' => 'Pendapatan bulanan pemohon'],
                ['kode' => 'C2.2', 'nama' => 'Penghasilan Pasangan', 'deskripsi' => 'Pendapatan bulanan pasangan (jika ada)'],
                ['kode' => 'C2.3', 'nama' => 'Performa Kredit Sebelumnya', 'deskripsi' => 'Riwayat pembayaran kredit sebelumnya'],
            ],
            // Capital (C3)
            'C3' => [
                ['kode' => 'C3.1', 'nama' => 'Pekerjaan', 'deskripsi' => 'Jenis dan stabilitas pekerjaan'],
                ['kode' => 'C3.2', 'nama' => 'Hutang Berjalan Pemohon', 'deskripsi' => 'Kewajiban hutang yang masih aktif'],
                ['kode' => 'C3.3', 'nama' => 'Tabungan Pemohon', 'deskripsi' => 'Jumlah tabungan dan investasi'],
            ],
            // Collateral (C4)
            'C4' => [
                ['kode' => 'C4.1', 'nama' => 'Nilai Properti', 'deskripsi' => 'Nilai pasar properti yang dijadikan jaminan'],
                ['kode' => 'C4.2', 'nama' => 'Kualitas Properti', 'deskripsi' => 'Kondisi dan kualitas properti jaminan'],
            ],
            // Condition (C5)
            'C5' => [
                ['kode' => 'C5.1', 'nama' => 'Jangka Waktu Kredit', 'deskripsi' => 'Periode waktu pengembalian kredit'],
                ['kode' => 'C5.2', 'nama' => 'Suku Bunga', 'deskripsi' => 'Tingkat suku bunga kredit'],
                ['kode' => 'C5.3', 'nama' => 'Inflasi', 'deskripsi' => 'Kondisi inflasi ekonomi saat ini'],
            ],
        ];

        foreach ($subCriterias as $criteriaKode => $subs) {
            $criteria = Criteria::where('kode', $criteriaKode)->first();
            
            if ($criteria) {
                foreach ($subs as $sub) {
                    SubCriteria::create([
                        'criteria_id' => $criteria->id,
                        'kode' => $sub['kode'],
                        'nama' => $sub['nama'],
                        'deskripsi' => $sub['deskripsi'],
                        'bobot' => 0.0000,
                        'is_active' => true,
                    ]);
                }
            }
        }
    }
}
