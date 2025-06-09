<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Evaluation;
use App\Models\Subcriteria;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index()
    {
        $alternatives = Alternative::with('evaluations.subcriteria.criteria')->get();
        $criteria = Criteria::with('subcriteria')->get();
        return view('evaluations.index', compact('alternatives', 'criteria'));
    }

    public function create()
    {
        $alternatives = Alternative::all();
        $subcriteria = Subcriteria::with('criteria')->get();
        return view('evaluations.create', compact('alternatives', 'subcriteria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alternative_id' => 'required|exists:alternatives,id',
            'subcriteria_id' => 'required|exists:subcriteria,id',
            'value' => 'required|numeric|min:1|max:9'
        ]);

        Evaluation::updateOrCreate(
            [
                'alternative_id' => $request->alternative_id,
                'subcriteria_id' => $request->subcriteria_id
            ],
            ['value' => $request->value]
        );

        return redirect()->route('evaluations.index')->with('success', 'Penilaian berhasil disimpan');
    }

    public function bulkEvaluate()
    {
        $alternatives = Alternative::all();
        $subcriteria = Subcriteria::with('criteria')->get();
        $evaluations = Evaluation::all()->keyBy(function($item) {
            return $item->alternative_id . '_' . $item->subcriteria_id;
        });

        return view('evaluations.bulk', compact('alternatives', 'subcriteria', 'evaluations'));
    }

    public function bulkStore(Request $request)
    {
        $evaluations = $request->input('evaluations', []);
        
        foreach ($evaluations as $alternativeId => $subcriteriaValues) {
            foreach ($subcriteriaValues as $subcriteriaId => $value) {
                if (!empty($value)) {
                    Evaluation::updateOrCreate(
                        [
                            'alternative_id' => $alternativeId,
                            'subcriteria_id' => $subcriteriaId
                        ],
                        ['value' => $value]
                    );
                }
            }
        }

        return redirect()->route('evaluations.index')->with('success', 'Semua penilaian berhasil disimpan');
    }

    public function calculate()
    {
        // First, check if criteria and subcriteria have weights
        $criteriaWithoutWeights = Criteria::where('weight', '<=', 0)->count();
        $subcriteriaWithoutWeights = Subcriteria::where('weight', '<=', 0)->count();
        
        if ($criteriaWithoutWeights > 0) {
            return redirect()->route('evaluations.index')
                ->with('error', 'Bobot kriteria belum dihitung. Silakan lakukan perbandingan berpasangan kriteria terlebih dahulu.');
        }
        
        if ($subcriteriaWithoutWeights > 0) {
            return redirect()->route('evaluations.index')
                ->with('error', 'Bobot sub kriteria belum dihitung. Silakan lakukan perbandingan berpasangan sub kriteria terlebih dahulu.');
        }

        // Check if there are evaluations
        $evaluationCount = Evaluation::count();
        if ($evaluationCount == 0) {
            return redirect()->route('evaluations.index')
                ->with('error', 'Belum ada data penilaian. Silakan isi penilaian terlebih dahulu.');
        }

        // Normalize evaluations for each subcriteria
        $subcriteria = Subcriteria::all();
        
        foreach ($subcriteria as $sub) {
            $evaluations = Evaluation::where('subcriteria_id', $sub->id)->get();
            
            if ($evaluations->count() > 0) {
                // Calculate sum of all values for this subcriteria (for normalization)
                $sumValues = $evaluations->sum('value');
                
                if ($sumValues > 0) {
                    foreach ($evaluations as $evaluation) {
                        // Normalize using sum method instead of max
                        $evaluation->normalized_value = $evaluation->value / $sumValues;
                        $evaluation->save();
                    }
                }
            }
        }

        // Calculate final scores for each alternative
        $alternatives = Alternative::all();
        
        foreach ($alternatives as $alternative) {
            $finalScore = 0;
            $criteria = Criteria::with('subcriteria')->where('weight', '>', 0)->get();
            
            foreach ($criteria as $criterion) {
                $criteriaScore = 0;
                $subcriteriaWithWeight = $criterion->subcriteria->where('weight', '>', 0);
                
                if ($subcriteriaWithWeight->count() > 0) {
                    foreach ($subcriteriaWithWeight as $sub) {
                        $evaluation = Evaluation::where('alternative_id', $alternative->id)
                                               ->where('subcriteria_id', $sub->id)
                                               ->first();
                        
                        if ($evaluation && $evaluation->normalized_value > 0) {
                            // Use subcriteria weight directly (assuming weights are already normalized)
                            $criteriaScore += $evaluation->normalized_value * $sub->weight;
                        }
                    }
                }
                
                // Multiply by criteria weight
                $finalScore += $criteriaScore * $criterion->weight;
            }
            
            $alternative->final_score = $finalScore;
            $alternative->save();
        }

        // Update rankings
        $rankedAlternatives = Alternative::where('final_score', '>', 0)
                                        ->orderBy('final_score', 'desc')
                                        ->get();
        
        foreach ($rankedAlternatives as $index => $alternative) {
            $alternative->rank = $index + 1;
            $alternative->save();
        }

        // Set rank 0 for alternatives with no score
        Alternative::where('final_score', '<=', 0)->update(['rank' => 0]);

        return redirect()->route('evaluations.results')
            ->with('success', 'Perhitungan AHP berhasil dilakukan. ' . $rankedAlternatives->count() . ' alternatif berhasil dihitung.')
            ->with('show_save_report', true); // Add this to show save report option
    }

    public function results()
    {
        $alternatives = Alternative::with('evaluations.subcriteria.criteria')
                                 ->orderBy('rank')
                                 ->get();
        $criteria = Criteria::with('subcriteria')->get();
        
        return view('evaluations.results', compact('alternatives', 'criteria'));
    }
}
