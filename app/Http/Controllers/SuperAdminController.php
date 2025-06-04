<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Evaluation;
use App\Models\Criteria;
use App\Models\SubCriteria;
use App\Models\AhpMatrix;
use App\Models\SubCriteriaParameter;
use App\Services\AhpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    protected $ahpService;

    public function __construct(AhpService $ahpService)
    {
        $this->ahpService = $ahpService;
    }

    public function dashboard()
    {
        $data = [
            'totalCustomers' => Customer::count(),
            'totalEvaluations' => Evaluation::count(),
            'approvedLoans' => Evaluation::where('status', 'approved')->count(),
            'totalUsers' => User::count(),
            'activeUsers' => User::where('is_active', true)->count(),
            'totalCriteria' => Criteria::count(),
            'totalSubCriteria' => SubCriteria::count(),
            'recentEvaluations' => Evaluation::with('customer')
                ->latest()
                ->take(5)
                ->get(),
            'ahpWeightsStatus' => 'Terkonfigurasi'
        ];

        return view('super-admin.dashboard', $data);
    }

    // Criteria Management
    public function criteriaIndex()
    {
        $criterias = Criteria::with('subCriterias')->get();
        return view('super-admin.criteria.index', compact('criterias'));
    }

    public function criteriaCreate()
    {
        return view('super-admin.criteria.create');
    }

    public function criteriaStore(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:criterias',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Criteria::create($request->all());

        return redirect()->route('super-admin.criteria.index')
            ->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function criteriaEdit(Criteria $criteria)
    {
        return view('super-admin.criteria.edit', compact('criteria'));
    }

    public function criteriaUpdate(Request $request, Criteria $criteria)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:criterias,kode,' . $criteria->id,
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $criteria->update($request->all());

        return redirect()->route('super-admin.criteria.index')
            ->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function criteriaDestroy(Criteria $criteria)
    {
        $criteria->delete();
        return redirect()->route('super-admin.criteria.index')
            ->with('success', 'Kriteria berhasil dihapus.');
    }

    // Sub Criteria Management
    public function subCriteriaIndex(Criteria $criteria)
    {
        $subCriterias = $criteria->subCriterias;
        return view('super-admin.criteria.sub-criteria.index', compact('criteria', 'subCriterias'));
    }

    public function subCriteriaCreate(Criteria $criteria)
    {
        return view('super-admin.criteria.sub-criteria.create', compact('criteria'));
    }

    public function subCriteriaStore(Request $request, Criteria $criteria)
    {
        $request->validate([
            'kode' => 'required|string|max:10',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $criteria->subCriterias()->create($request->all());

        return redirect()->route('super-admin.criteria.sub-criteria.index', $criteria)
            ->with('success', 'Sub kriteria berhasil ditambahkan.');
    }

    public function subCriteriaEdit(Criteria $criteria, SubCriteria $subCriteria)
    {
        return view('super-admin.criteria.sub-criteria.edit', compact('criteria', 'subCriteria'));
    }

    public function subCriteriaUpdate(Request $request, Criteria $criteria, SubCriteria $subCriteria)
    {
        $request->validate([
            'kode' => 'required|string|max:10',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $subCriteria->update($request->all());

        return redirect()->route('super-admin.criteria.sub-criteria.index', $criteria)
            ->with('success', 'Sub kriteria berhasil diperbarui.');
    }

    public function subCriteriaDestroy(Criteria $criteria, SubCriteria $subCriteria)
    {
        $subCriteria->delete();
        return redirect()->route('super-admin.criteria.sub-criteria.index', $criteria)
            ->with('success', 'Sub kriteria berhasil dihapus.');
    }

    // AHP Weights Management
    public function ahpWeightsIndex()
    {
        $criterias = Criteria::with('subCriterias')->where('is_active', true)->get();
        $criteriaMatrix = AhpMatrix::where('comparison_type', 'criteria')->latest()->first();
        
        return view('super-admin.ahp-weights.index', compact('criterias', 'criteriaMatrix'));
    }

    public function ahpCriteriaWeights()
    {
        $criterias = Criteria::where('is_active', true)->get();
        $existingMatrix = AhpMatrix::where('comparison_type', 'criteria')->latest()->first();
        
        $matrix = [];
        if ($existingMatrix) {
            $matrix = $existingMatrix->matrix_data;
        } else {
            $matrix = $this->ahpService->generateDefaultMatrix($criterias);
        }
        
        return view('super-admin.ahp-weights.criteria', compact('criterias', 'matrix', 'existingMatrix'));
    }

    public function ahpCriteriaWeightsStore(Request $request)
    {
        $criterias = Criteria::where('is_active', true)->get();
        $matrix = [];
        
        // Build matrix dari form input
        foreach ($criterias as $i => $criteria1) {
            foreach ($criterias as $j => $criteria2) {
                if ($i == $j) {
                    $matrix[$i][$j] = 1;
                } elseif ($i < $j) {
                    $value = (float) $request->input("comparison_{$i}_{$j}", 1);
                    $matrix[$i][$j] = $value;
                    $matrix[$j][$i] = 1 / $value;
                }
            }
        }
        
        // Hitung bobot dan konsistensi
        $weights = $this->ahpService->calculateWeights($matrix);
        $consistencyRatio = $this->ahpService->calculateConsistencyRatio($matrix, $weights);
        $isValid = $this->ahpService->isConsistent($consistencyRatio);
        
        // Simpan atau update matriks
        AhpMatrix::updateOrCreate(
            ['comparison_type' => 'criteria'],
            [
                'matrix_data' => $matrix,
                'weights' => $weights,
                'consistency_ratio' => $consistencyRatio,
                'is_valid' => $isValid,
                'created_by' => Auth::id(), // CHANGED: auth()->id() to Auth::id()
            ]
        );
        
        // Update bobot di tabel kriteria
        foreach ($criterias as $i => $criteria) {
            $criteria->update(['bobot' => $weights[$i]]);
        }
        
        $message = $isValid 
            ? 'Bobot kriteria berhasil disimpan dan konsisten.' 
            : 'Bobot kriteria disimpan tetapi tidak konsisten (CR = ' . number_format($consistencyRatio, 4) . '). Silakan review kembali.';
            
        return redirect()->route('super-admin.ahp-weights.index')
            ->with($isValid ? 'success' : 'warning', $message);
    }

    public function ahpSubCriteriaWeights(Criteria $criteria)
    {
        $subCriterias = $criteria->subCriterias()->where('is_active', true)->get();
        $existingMatrix = AhpMatrix::where('comparison_type', 'sub_criteria')
            ->where('criteria_id', $criteria->id)
            ->latest()
            ->first();
        
        $matrix = [];
        if ($existingMatrix) {
            $matrix = $existingMatrix->matrix_data;
        } else {
            $matrix = $this->ahpService->generateDefaultMatrix($subCriterias);
        }
        
        return view('super-admin.ahp-weights.sub-criteria', compact('criteria', 'subCriterias', 'matrix', 'existingMatrix'));
    }

    public function ahpSubCriteriaWeightsStore(Request $request, Criteria $criteria)
    {
        $subCriterias = $criteria->subCriterias()->where('is_active', true)->get();
        $matrix = [];
        
        // Build matrix dari form input
        foreach ($subCriterias as $i => $sub1) {
            foreach ($subCriterias as $j => $sub2) {
                if ($i == $j) {
                    $matrix[$i][$j] = 1;
                } elseif ($i < $j) {
                    $value = (float) $request->input("comparison_{$i}_{$j}", 1);
                    $matrix[$i][$j] = $value;
                    $matrix[$j][$i] = 1 / $value;
                }
            }
        }
        
        // Hitung bobot dan konsistensi
        $weights = $this->ahpService->calculateWeights($matrix);
        $consistencyRatio = $this->ahpService->calculateConsistencyRatio($matrix, $weights);
        $isValid = $this->ahpService->isConsistent($consistencyRatio);
        
        // Simpan atau update matriks
        AhpMatrix::updateOrCreate(
            [
                'comparison_type' => 'sub_criteria',
                'criteria_id' => $criteria->id
            ],
            [
                'matrix_data' => $matrix,
                'weights' => $weights,
                'consistency_ratio' => $consistencyRatio,
                'is_valid' => $isValid,
                'created_by' => Auth::id(), // CHANGED: auth()->id() to Auth::id()
            ]
        );
        
        // Update bobot di tabel sub kriteria
        foreach ($subCriterias as $i => $subCriteria) {
            $subCriteria->update(['bobot' => $weights[$i]]);
        }
        
        $message = $isValid 
            ? 'Bobot sub kriteria berhasil disimpan dan konsisten.' 
            : 'Bobot sub kriteria disimpan tetapi tidak konsisten (CR = ' . number_format($consistencyRatio, 4) . '). Silakan review kembali.';
            
        return redirect()->route('super-admin.ahp-weights.index')
            ->with($isValid ? 'success' : 'warning', $message);
    }

    // User Management
    public function usersIndex()
    {
        $users = User::with('evaluations')->orderBy('created_at', 'desc')->get();
        return view('super-admin.users.index', compact('users'));
    }

    public function usersCreate()
    {
        return view('super-admin.users.create');
    }

    public function usersStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:super_admin,admin',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'address' => $request->address,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function usersShow(User $user)
    {
        $user->load('evaluations.customer');
        return view('super-admin.users.show', compact('user'));
    }

    public function usersEdit(User $user)
    {
        return view('super-admin.users.edit', compact('user'));
    }

    public function usersUpdate(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:super_admin,admin',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'address' => $request->address,
            'is_active' => $request->boolean('is_active'),
        ];

        // Update password jika diisi
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function usersDestroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id == Auth::id()) {
            return redirect()->route('super-admin.users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    // Reports Management
    public function reportsIndex()
    {
        $data = [
            'totalEvaluations' => Evaluation::count(),
            'totalCustomers' => Customer::count(),
            'approvedLoans' => Evaluation::where('status', 'approved')->count(),
            'rejectedLoans' => Evaluation::where('status', 'rejected')->count(),
        ];
        
        return view('super-admin.reports.index', $data);
    }

    public function reportsEvaluations(Request $request)
    {
        $query = Evaluation::with(['customer', 'evaluator']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by evaluator
        if ($request->filled('evaluator')) {
            $query->where('evaluator_id', $request->evaluator);
        }
        
        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        $evaluations = $query->latest()->paginate(15);
        
        return view('super-admin.reports.evaluations', compact('evaluations'));
    }

    public function reportsCustomers(Request $request)
    {
        $query = Customer::with('evaluations');
        
        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filter by evaluation status
        if ($request->filled('evaluation_status')) {
            if ($request->evaluation_status === 'evaluated') {
                $query->has('evaluations');
            } elseif ($request->evaluation_status === 'not_evaluated') {
                $query->doesntHave('evaluations');
            }
        }
        
        // Filter by registration period
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'this_month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', now()->subMonth()->month)
                          ->whereYear('created_at', now()->subMonth()->year);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', now()->year);
                    break;
            }
        }
        
        $customers = $query->latest()->paginate(15);
        
        return view('super-admin.reports.customers', compact('customers'));
    }

    public function reportsExport(Request $request)
    {
        // Basic export functionality
        $type = $request->get('type', 'all');
        
        switch ($type) {
            case 'evaluations':
                $data = Evaluation::with(['customer', 'evaluator'])->get();
                $filename = 'laporan_evaluasi_' . date('Y-m-d') . '.json';
                break;
                
            case 'customers':
                $data = Customer::with('evaluations')->get();
                $filename = 'data_customer_' . date('Y-m-d') . '.json';
                break;
                
            default:
                $data = [
                    'evaluations' => Evaluation::with(['customer', 'evaluator'])->get(),
                    'customers' => Customer::with('evaluations')->get(),
                    'summary' => [
                        'total_evaluations' => Evaluation::count(),
                        'total_customers' => Customer::count(),
                        'approved_loans' => Evaluation::where('status', 'approved')->count(),
                        'rejected_loans' => Evaluation::where('status', 'rejected')->count(),
                    ]
                ];
                $filename = 'laporan_lengkap_' . date('Y-m-d') . '.json';
        }
        
        return response()->json($data)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    // Sub Criteria Parameters Management
    public function subCriteriaParametersIndex(Criteria $criteria, SubCriteria $subCriteria)
    {
        $parameters = $subCriteria->parameters()->orderBy('urutan')->get();
        return view('super-admin.criteria.sub-criteria.parameters.index', compact('criteria', 'subCriteria', 'parameters'));
    }

    public function subCriteriaParametersCreate(Criteria $criteria, SubCriteria $subCriteria)
    {
        return view('super-admin.criteria.sub-criteria.parameters.create', compact('criteria', 'subCriteria'));
    }

    public function subCriteriaParametersStore(Request $request, Criteria $criteria, SubCriteria $subCriteria)
    {
        $request->validate([
            'parameter_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'nilai' => 'required|numeric|min:0',
            'urutan' => 'required|integer|min:1',
        ]);

        $subCriteria->parameters()->create($request->all());

        return redirect()->route('super-admin.criteria.sub-criteria.parameters.index', [$criteria, $subCriteria])
            ->with('success', 'Parameter berhasil ditambahkan.');
    }

    public function subCriteriaParametersEdit(Criteria $criteria, SubCriteria $subCriteria, SubCriteriaParameter $parameter)
    {
        return view('super-admin.criteria.sub-criteria.parameters.edit', compact('criteria', 'subCriteria', 'parameter'));
    }

    public function subCriteriaParametersUpdate(Request $request, Criteria $criteria, SubCriteria $subCriteria, SubCriteriaParameter $parameter)
    {
        $request->validate([
            'parameter_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'nilai' => 'required|numeric|min:0',
            'urutan' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $parameter->update($request->all());

        return redirect()->route('super-admin.criteria.sub-criteria.parameters.index', [$criteria, $subCriteria])
            ->with('success', 'Parameter berhasil diperbarui.');
    }

    public function subCriteriaParametersDestroy(Criteria $criteria, SubCriteria $subCriteria, SubCriteriaParameter $parameter)
    {
        $parameter->delete();
        return redirect()->route('super-admin.criteria.sub-criteria.parameters.index', [$criteria, $subCriteria])
            ->with('success', 'Parameter berhasil dihapus.');
    }
}
