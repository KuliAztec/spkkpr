<?php

namespace Database\Seeders;

use App\Models\Alternative;
use App\Models\Subcriteria;
use App\Models\Evaluation;
use Illuminate\Database\Seeder;

class EvaluationSeeder extends Seeder
{
    public function run()
    {
        $alternatives = Alternative::all();
        $subcriteria = Subcriteria::all();

        foreach ($alternatives as $alternative) {
            foreach ($subcriteria as $sub) {
                // Generate random evaluation values between 1-9
                $value = rand(1, 9);
                
                Evaluation::create([
                    'alternative_id' => $alternative->id,
                    'subcriteria_id' => $sub->id,
                    'value' => $value,
                    'normalized_value' => 0.0 // Will be calculated later
                ]);
            }
        }
    }
}
