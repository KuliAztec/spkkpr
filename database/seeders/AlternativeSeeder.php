<?php

namespace Database\Seeders;

use App\Models\Alternative;
use Illuminate\Database\Seeder;

class AlternativeSeeder extends Seeder
{
    public function run()
    {
        $alternatives = [
            [
                'code' => 'A1',
                'name' => 'Ahmad Rizki Pratama',
                'email' => 'ahmad.rizki@email.com',
                'phone' => '081234567801',
                'address' => 'Jl. Merdeka No. 12, Jakarta Pusat',
                'final_score' => 0.0,
                'rank' => 0
            ],
            [
                'code' => 'A2',
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@email.com',
                'phone' => '081234567802',
                'address' => 'Jl. Sudirman No. 45, Jakarta Selatan',
                'final_score' => 0.0,
                'rank' => 0
            ],
            [
                'code' => 'A3',
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@email.com',
                'phone' => '081234567803',
                'address' => 'Jl. Gatot Subroto No. 78, Jakarta Barat',
                'final_score' => 0.0,
                'rank' => 0
            ],
            [
                'code' => 'A4',
                'name' => 'Maya Sari Dewi',
                'email' => 'maya.sari@email.com',
                'phone' => '081234567804',
                'address' => 'Jl. Thamrin No. 23, Jakarta Pusat',
                'final_score' => 0.0,
                'rank' => 0
            ],
            [
                'code' => 'A5',
                'name' => 'Doni Wijaya',
                'email' => 'doni.wijaya@email.com',
                'phone' => '081234567805',
                'address' => 'Jl. Kemang Raya No. 56, Jakarta Selatan',
                'final_score' => 0.0,
                'rank' => 0
            ],
            [
                'code' => 'A6',
                'name' => 'Rina Kusumawati',
                'email' => 'rina.kusuma@email.com',
                'phone' => '081234567806',
                'address' => 'Jl. Cikini No. 34, Jakarta Pusat',
                'final_score' => 0.0,
                'rank' => 0
            ],
            [
                'code' => 'A7',
                'name' => 'Eko Prasetyo',
                'email' => 'eko.prasetyo@email.com',
                'phone' => '081234567807',
                'address' => 'Jl. Menteng No. 67, Jakarta Pusat',
                'final_score' => 0.0,
                'rank' => 0
            ],
            [
                'code' => 'A8',
                'name' => 'Fitri Handayani',
                'email' => 'fitri.handayani@email.com',
                'phone' => '081234567808',
                'address' => 'Jl. Senopati No. 89, Jakarta Selatan',
                'final_score' => 0.0,
                'rank' => 0
            ],
            [
                'code' => 'A9',
                'name' => 'Hendra Gunawan',
                'email' => 'hendra.gunawan@email.com',
                'phone' => '081234567809',
                'address' => 'Jl. Kuningan No. 12, Jakarta Selatan',
                'final_score' => 0.0,
                'rank' => 0
            ],
            [
                'code' => 'A10',
                'name' => 'Indira Permatasari',
                'email' => 'indira.permata@email.com',
                'phone' => '081234567810',
                'address' => 'Jl. Cipete No. 45, Jakarta Selatan',
                'final_score' => 0.0,
                'rank' => 0
            ]
        ];

        foreach ($alternatives as $alternative) {
            Alternative::create($alternative);
        }
    }
}
