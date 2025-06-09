<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Subcriteria;
use Illuminate\Http\Request;

class AlternativeController extends Controller
{
    public function index()
    {
        $alternatives = Alternative::with(['parameters.subcriteria.criteria'])->orderBy('rank')->get();
        $subcriteria = Subcriteria::with(['criteria', 'parameters' => function($query) {
            $query->orderBy('urutan');
        }])->get()->groupBy('criteria.name');
        
        return view('alternatives.index', compact('alternatives', 'subcriteria'));
    }

    public function create()
    {
        return view('alternatives.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:alternatives|max:10',
            'name' => 'required|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|max:20',
            'address' => 'nullable'
        ]);

        Alternative::create($request->all());
        return redirect()->route('alternatives.index')->with('success', 'Nasabah berhasil ditambahkan');
    }

    public function show(Alternative $alternative)
    {
        $alternative->load('evaluations.subcriteria.criteria');
        return view('alternatives.show', compact('alternative'));
    }

    public function edit(Alternative $alternative)
    {
        return view('alternatives.edit', compact('alternative'));
    }

    public function update(Request $request, Alternative $alternative)
    {
        $request->validate([
            'code' => 'required|max:10|unique:alternatives,code,' . $alternative->id,
            'name' => 'required|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|max:20',
            'address' => 'nullable'
        ]);

        $alternative->update($request->all());
        return redirect()->route('alternatives.index')->with('success', 'Data nasabah berhasil diupdate');
    }

    public function destroy(Alternative $alternative)
    {
        $alternative->delete();
        return redirect()->route('alternatives.index')->with('success', 'Data nasabah berhasil dihapus');
    }

    public function parameters(Alternative $alternative)
    {
        $subcriteria = Subcriteria::with(['parameters' => function($query) {
            $query->orderBy('urutan');
        }, 'criteria'])->get()->groupBy('criteria.name');
        
        $selectedParameters = $alternative->parameters->keyBy('subcriteria_id');
        
        return view('alternatives.parameters', compact('alternative', 'subcriteria', 'selectedParameters'));
    }

    public function storeParameters(Request $request, Alternative $alternative)
    {
        $parameters = $request->input('parameters', []);
        
        // Sync parameters
        $alternative->parameters()->sync($parameters);
        
        return redirect()->route('alternatives.show', $alternative)
            ->with('success', 'Parameter nasabah berhasil disimpan');
    }

    public function getParameters(Alternative $alternative)
    {
        $parameters = $alternative->parameters()
            ->with(['subcriteria.criteria'])
            ->get()
            ->groupBy('subcriteria.criteria.name');
        
        return response()->json($parameters);
    }
}
