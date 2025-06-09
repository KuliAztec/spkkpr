<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Subcriteria;
use Illuminate\Http\Request;

class SubcriteriaController extends Controller
{
    public function index()
    {
        $subcriteria = Subcriteria::with('criteria')->get();
        return view('subcriteria.index', compact('subcriteria'));
    }

    public function create()
    {
        $criteria = Criteria::all();
        $selectedCriteria = request()->get('criteria'); // Get criteria from URL parameter
        return view('subcriteria.create', compact('criteria', 'selectedCriteria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'criteria_id' => 'required|exists:criteria,id',
            'code' => 'required|max:10',
            'name' => 'required|max:255',
            'description' => 'nullable'
        ]);

        Subcriteria::create($request->all());
        return redirect()->route('subcriteria.index')->with('success', 'Subkriteria berhasil ditambahkan');
    }

    public function show(Subcriteria $subcriteria)
    {
        $subcriteria->load('criteria');
        return view('subcriteria.show', compact('subcriteria'));
    }

    public function edit(Subcriteria $subcriteria)
    {
        $criteria = Criteria::all();
        return view('subcriteria.edit', compact('subcriteria', 'criteria'));
    }

    public function update(Request $request, Subcriteria $subcriteria)
    {
        $request->validate([
            'criteria_id' => 'required|exists:criteria,id',
            'code' => 'required|max:10',
            'name' => 'required|max:255',
            'description' => 'nullable'
        ]);

        $subcriteria->update($request->all());
        return redirect()->route('subcriteria.index')->with('success', 'Subkriteria berhasil diupdate');
    }

    public function destroy(Subcriteria $subcriteria)
    {
        $subcriteria->delete();
        return redirect()->route('subcriteria.index')->with('success', 'Subkriteria berhasil dihapus');
    }

    public function pairwiseComparison($criteriaId)
    {
        $criteria = Criteria::findOrFail($criteriaId);
        $subcriteria = $criteria->subcriteria;
        
        if ($subcriteria->count() < 2) {
            return redirect()->route('subcriteria.index')
                ->with('error', 'Minimal 2 subkriteria diperlukan untuk perbandingan berpasangan');
        }

        return view('subcriteria.pairwise', compact('criteria', 'subcriteria'));
    }

    public function storePairwiseComparison(Request $request, $criteriaId)
    {
        $criteria = Criteria::findOrFail($criteriaId);
        $subcriteria = $criteria->subcriteria;
        $comparisons = $request->input('comparisons', []);
        
        // Build comparison matrix
        $matrix = [];
        foreach ($subcriteria as $i => $sub1) {
            foreach ($subcriteria as $j => $sub2) {
                if ($i == $j) {
                    $matrix[$i][$j] = 1;
                } elseif ($i < $j) {
                    $value = $comparisons[$sub1->id][$sub2->id] ?? 1;
                    $matrix[$i][$j] = $value;
                    $matrix[$j][$i] = 1 / $value;
                }
            }
        }

        // Calculate weights
        $weights = $this->calculateWeights($matrix);
        
        // Update subcriteria weights
        foreach ($subcriteria as $i => $sub) {
            $sub->update(['weight' => $weights[$i]]);
        }

        return redirect()->route('subcriteria.index')
            ->with('success', 'Bobot subkriteria berhasil dihitung dari perbandingan berpasangan');
    }

    private function calculateWeights($matrix)
    {
        $n = count($matrix);
        $weights = [];
        
        // Calculate column sums
        $columnSums = [];
        for ($j = 0; $j < $n; $j++) {
            $sum = 0;
            for ($i = 0; $i < $n; $i++) {
                $sum += $matrix[$i][$j];
            }
            $columnSums[$j] = $sum;
        }
        
        // Normalize matrix and calculate row averages
        for ($i = 0; $i < $n; $i++) {
            $rowSum = 0;
            for ($j = 0; $j < $n; $j++) {
                $rowSum += $matrix[$i][$j] / $columnSums[$j];
            }
            $weights[$i] = $rowSum / $n;
        }
        
        return $weights;
    }
}
