<?php

namespace Database\Seeders;

use App\Models\Criteria;
use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
{
    public function run()
    {
        $criteria = [
            [
                'code' => 'C1',
                'name' => 'Character',
                'description' => 'Kriteria karakter dan kepribadian nasabah dalam hal kredibilitas dan kejujuran',
                'weight' => 0.0
            ],
            [
                'code' => 'C2',
                'name' => 'Capacity',
                'description' => 'Kriteria kemampuan nasabah dalam membayar kredit berdasarkan penghasilan',
                'weight' => 0.0
            ],
            [
                'code' => 'C3',
                'name' => 'Capital',
                'description' => 'Kriteria modal dan kekayaan yang dimiliki nasabah',
                'weight' => 0.0
            ],
            [
                'code' => 'C4',
                'name' => 'Collateral',
                'description' => 'Kriteria jaminan yang dapat diberikan nasabah',
                'weight' => 0.0
            ],
            [
                'code' => 'C5',
                'name' => 'Condition',
                'description' => 'Kriteria kondisi ekonomi dan syarat-syarat kredit',
                'weight' => 0.0
            ]
        ];

        foreach ($criteria as $criterion) {
            Criteria::create($criterion);
        }
    }
}
