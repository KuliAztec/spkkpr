<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function index()
    {
        $criteria = Criteria::with('subcriteria')->get();
        return view('criteria.index', compact('criteria'));
    }

    public function create()
    {
        return view('criteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:criteria|max:10',
            'name' => 'required|max:255',
            'description' => 'nullable'
        ]);

        Criteria::create($request->all());
        return redirect()->route('criteria.index')->with('success', 'Kriteria berhasil ditambahkan');
    }

    public function show(Criteria $criteria)
    {
        $criteria->load('subcriteria');
        return view('criteria.show', compact('criteria'));
    }

    public function edit(Criteria $criteria)
    {
        return view('criteria.edit', compact('criteria'));
    }

    public function update(Request $request, Criteria $criteria)
    {
        $request->validate([
            'code' => 'required|max:10|unique:criteria,code,' . $criteria->id,
            'name' => 'required|max:255',
            'description' => 'nullable'
        ]);

        $criteria->update($request->all());
        return redirect()->route('criteria.index')->with('success', 'Kriteria berhasil diupdate');
    }

    public function destroy(Criteria $criteria)
    {
        $criteria->delete();
        return redirect()->route('criteria.index')->with('success', 'Kriteria berhasil dihapus');
    }

    public function pairwiseComparison()
    {
        $criteria = Criteria::all();
        
        if ($criteria->count() < 2) {
            return redirect()->route('criteria.index')
                ->with('error', 'Minimal 2 kriteria diperlukan untuk perbandingan berpasangan');
        }

        return view('criteria.pairwise', compact('criteria'));
    }

    public function storePairwiseComparison(Request $request)
    {
        $criteria = Criteria::all();
        $comparisons = $request->input('comparisons', []);
        
        // Build comparison matrix
        $matrix = [];
        foreach ($criteria as $i => $criterion1) {
            foreach ($criteria as $j => $criterion2) {
                if ($i == $j) {
                    $matrix[$i][$j] = 1;
                } elseif ($i < $j) {
                    $value = $comparisons[$criterion1->id][$criterion2->id] ?? 1;
                    $matrix[$i][$j] = $value;
                    $matrix[$j][$i] = 1 / $value;
                }
            }
        }

        // Calculate weights using eigenvector method
        $weights = $this->calculateWeights($matrix);
        
        // Update criteria weights
        foreach ($criteria as $i => $criterion) {
            $criterion->update(['weight' => $weights[$i]]);
        }

        return redirect()->route('criteria.index')
            ->with('success', 'Bobot kriteria berhasil dihitung dari perbandingan berpasangan');
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
