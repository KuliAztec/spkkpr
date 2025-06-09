<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Evaluation;
use App\Models\EvaluationReport;
use App\Models\Subcriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isSuperAdmin()) {
            // SuperAdmin sees everything
            $criteria = Criteria::count();
            $subcriteria = Subcriteria::count();
            $alternatives = Alternative::count();
            $evaluations = Evaluation::count();
            $reports = EvaluationReport::count();
            
            return view('dashboard.index', compact('criteria', 'subcriteria', 'alternatives', 'evaluations', 'reports'));
        } else {
            // Admin sees only their accessible data
            $alternatives = Alternative::count();
            $evaluations = Evaluation::count();
            $reports = EvaluationReport::count();
            
            return view('dashboard.index', compact('alternatives', 'evaluations', 'reports'));
        }
    }
}
