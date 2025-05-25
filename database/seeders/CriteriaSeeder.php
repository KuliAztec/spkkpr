<?php

namespace Database\Seeders;

use App\Models\Criteria;
use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criterias = [
            [
                'kode' => 'C1',
                'nama' => 'Character',
                'deskripsi' => 'Penilaian karakter dan kepribadian pemohon kredit',
                'bobot' => 0.0000,
                'is_active' => true,
            ],
            [
                'kode' => 'C2',
                'nama' => 'Capacity',
                'deskripsi' => 'Kemampuan pemohon untuk membayar kredit',
                'bobot' => 0.0000,
                'is_active' => true,
            ],
            [
                'kode' => 'C3',
                'nama' => 'Capital',
                'deskripsi' => 'Modal dan aset yang dimiliki pemohon',
                'bobot' => 0.0000,
                'is_active' => true,
            ],
            [
                'kode' => 'C4',
                'nama' => 'Collateral',
                'deskripsi' => 'Jaminan yang diberikan pemohon',
                'bobot' => 0.0000,
                'is_active' => true,
            ],
            [
                'kode' => 'C5',
                'nama' => 'Condition',
                'deskripsi' => 'Kondisi ekonomi dan persyaratan kredit',
                'bobot' => 0.0000,
                'is_active' => true,
            ],
        ];

        foreach ($criterias as $criteria) {
            Criteria::create($criteria);
        }
    }
}
