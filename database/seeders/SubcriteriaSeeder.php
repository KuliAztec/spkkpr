<?php

namespace Database\Seeders;

use App\Models\Criteria;
use App\Models\Subcriteria;
use Illuminate\Database\Seeder;

class SubcriteriaSeeder extends Seeder
{
    public function run()
    {
        // Get criteria IDs
        $character = Criteria::where('code', 'C1')->first();
        $capacity = Criteria::where('code', 'C2')->first();
        $capital = Criteria::where('code', 'C3')->first();
        $collateral = Criteria::where('code', 'C4')->first();
        $condition = Criteria::where('code', 'C5')->first();

        $subcriteria = [
            // Character Subcriteria
            [
                'criteria_id' => $character->id,
                'code' => 'C1.1',
                'name' => 'Checking BI',
                'description' => 'Riwayat kredit nasabah di Bank Indonesia',
                'weight' => 0.0
            ],
            [
                'criteria_id' => $character->id,
                'code' => 'C1.2',
                'name' => 'Usia',
                'description' => 'Usia nasabah saat mengajukan kredit',
                'weight' => 0.0
            ],
            [
                'criteria_id' => $character->id,
                'code' => 'C1.3',
                'name' => 'Prestasi Pekerjaan',
                'description' => 'Prestasi dan pencapaian dalam pekerjaan',
                'weight' => 0.0
            ],
            [
                'criteria_id' => $character->id,
                'code' => 'C1.4',
                'name' => 'Karakter',
                'description' => 'Sifat dan perilaku nasabah dalam kehidupan sehari-hari',
                'weight' => 0.0
            ],
            [
                'criteria_id' => $character->id,
                'code' => 'C1.5',
                'name' => 'Loyalitas Nasabah',
                'description' => 'Kesetiaan nasabah terhadap bank',
                'weight' => 0.0
            ],

            // Capacity Subcriteria
            [
                'criteria_id' => $capacity->id,
                'code' => 'C2.1',
                'name' => 'Penghasilan Pribadi',
                'description' => 'Penghasilan bulanan nasabah dari pekerjaan utama',
                'weight' => 0.0
            ],
            [
                'criteria_id' => $capacity->id,
                'code' => 'C2.2',
                'name' => 'Penghasilan Pasangan',
                'description' => 'Penghasilan bulanan pasangan nasabah',
                'weight' => 0.0
            ],
            [
                'criteria_id' => $capacity->id,
                'code' => 'C2.3',
                'name' => 'Performa Kredit Sebelumnya',
                'description' => 'Riwayat pembayaran kredit sebelumnya',
                'weight' => 0.0
            ],

            // Capital Subcriteria
            [
                'criteria_id' => $capital->id,
                'code' => 'C3.1',
                'name' => 'Pekerjaan',
                'description' => 'Status dan jenis pekerjaan nasabah',
                'weight' => 0.0
            ],
            [
                'criteria_id' => $capital->id,
                'code' => 'C3.2',
                'name' => 'Hutang Berjalan Pemohon',
                'description' => 'Total hutang yang sedang berjalan',
                'weight' => 0.0
            ],
            [
                'criteria_id' => $capital->id,
                'code' => 'C3.3',
                'name' => 'Tabungan Pemohon',
                'description' => 'Jumlah tabungan yang dimiliki nasabah',
                'weight' => 0.0
            ],

            // Collateral Subcriteria
            [
                'criteria_id' => $collateral->id,
                'code' => 'C4.1',
                'name' => 'Nilai Properti',
                'description' => 'Nilai pasar properti yang dijadikan jaminan',
                'weight' => 0.0
            ],
            [
                'criteria_id' => $collateral->id,
                'code' => 'C4.2',
                'name' => 'Kualitas Properti',
                'description' => 'Kondisi dan kualitas properti jaminan',
                'weight' => 0.0
            ],

            // Condition Subcriteria
            [
                'criteria_id' => $condition->id,
                'code' => 'C5.1',
                'name' => 'Jangka Waktu Kredit',
                'description' => 'Periode waktu pengembalian kredit',
                'weight' => 0.0
            ],
            [
                'criteria_id' => $condition->id,
                'code' => 'C5.2',
                'name' => 'Suku Bunga',
                'description' => 'Tingkat suku bunga yang berlaku',
                'weight' => 0.0
            ],
            [
                'criteria_id' => $condition->id,
                'code' => 'C5.3',
                'name' => 'Inflasi',
                'description' => 'Kondisi inflasi pada saat pengajuan kredit',
                'weight' => 0.0
            ]
        ];

        foreach ($subcriteria as $sub) {
            Subcriteria::create($sub);
        }
    }
}
