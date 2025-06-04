@extends('layouts.superadmin')

@section('title', 'Tambah Parameter - ' . $subCriteria->nama)

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Parameter</h1>
            <nav class="flex mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('super-admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route('super-admin.criteria.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Kriteria</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route('super-admin.criteria.sub-criteria.index', $criteria) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Sub Kriteria</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route('super-admin.criteria.sub-criteria.parameters.index', [$criteria, $subCriteria]) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Parameter</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Tambah Parameter</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md mb-6" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm"><strong>Error!</strong> {{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-plus text-blue-600 mr-2"></i>Form Tambah Parameter
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Kriteria: <span class="font-medium">{{ $criteria->nama }}</span> → 
                        Sub Kriteria: <span class="font-medium">{{ $subCriteria->nama }}</span>
                    </p>
                </div>
                
                <div class="px-6 py-4">
                    <form action="{{ route('super-admin.criteria.sub-criteria.parameters.store', [$criteria, $subCriteria]) }}" method="POST" id="parameterForm">
                        @csrf
                        
                        <!-- Parameter Name & Order Row -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                            <div class="md:col-span-3">
                                <label for="parameter_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Parameter <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('parameter_name') border-red-500 @enderror" 
                                           id="parameter_name" 
                                           name="parameter_name" 
                                           value="{{ old('parameter_name') }}" 
                                           placeholder="Contoh: Kredit Lancar"
                                           autocomplete="off">
                                    <!-- Auto-suggestion dropdown -->
                                    <div id="suggestions" class="hidden absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg mt-1 max-h-60 overflow-auto">
                                        <!-- Suggestions will be populated by JavaScript -->
                                    </div>
                                </div>
                                @error('parameter_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-1">
                                <label for="urutan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Urutan <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('urutan') border-red-500 @enderror" 
                                       id="urutan" 
                                       name="urutan" 
                                       value="{{ old('urutan', 1) }}" 
                                       min="1"
                                       placeholder="1">
                                @error('urutan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3" 
                                      placeholder="Deskripsi parameter (opsional)">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Jelaskan parameter ini secara detail untuk mempermudah evaluasi</p>
                        </div>
                        
                        <!-- Value & Status Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="nilai" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nilai <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       step="0.01"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nilai') border-red-500 @enderror" 
                                       id="nilai" 
                                       name="nilai" 
                                       value="{{ old('nilai') }}" 
                                       placeholder="50"
                                       min="0">
                                @error('nilai')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Nilai numerik untuk parameter (contoh: 1-100)</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <div class="flex items-center space-x-6">
                                    <label class="flex items-center">
                                        <input type="radio" 
                                               name="is_active" 
                                               value="1" 
                                               {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-2 text-sm text-gray-900">
                                            <i class="fas fa-check-circle text-green-500 mr-1"></i>Aktif
                                        </span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" 
                                               name="is_active" 
                                               value="0" 
                                               {{ old('is_active') == '0' ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-2 text-sm text-gray-900">
                                            <i class="fas fa-times-circle text-gray-400 mr-1"></i>Tidak Aktif
                                        </span>
                                    </label>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Parameter aktif akan digunakan dalam evaluasi</p>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                            <a href="{{ route('super-admin.criteria.sub-criteria.parameters.index', [$criteria, $subCriteria]) }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-arrow-left mr-2"></i> Kembali
                            </a>
                            
                            <div class="flex space-x-3">
                                <button type="reset" 
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    <i class="fas fa-undo mr-2"></i> Reset
                                </button>
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-save mr-2"></i> Simpan Parameter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="lg:col-span-1">
            <!-- Criteria Info -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>Informasi
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <div class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Kriteria</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $criteria->kode }}
                                </span>
                                <p class="text-sm text-gray-900 mt-1">{{ $criteria->nama }}</p>
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Sub Kriteria</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $subCriteria->kode }}
                                </span>
                                <p class="text-sm text-gray-900 mt-1">{{ $subCriteria->nama }}</p>
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Bobot Sub Kriteria</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ number_format($subCriteria->bobot ?? 0, 3) }}
                            </dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guidelines -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>Panduan
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                            <span>Nama parameter harus unik dalam sub kriteria</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                            <span>Urutan menentukan posisi parameter dalam evaluasi</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                            <span>Nilai yang lebih tinggi menunjukkan hasil evaluasi yang lebih baik</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                            <span>Deskripsi membantu evaluator memahami parameter</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-suggest untuk parameter umum
    const commonParameters = {
        'Character': [
            { name: 'Kredit Lancar', nilai: 50, description: 'Kredit yang pembayarannya lancar sesuai jadwal' },
            { name: 'Kredit Dalam Perhatian Khusus', nilai: 40, description: 'Kredit yang mengalami keterlambatan 1-90 hari' },
            { name: 'Kredit Kurang Lancar', nilai: 30, description: 'Kredit yang mengalami keterlambatan 91-120 hari' },
            { name: 'Kredit Diragukan', nilai: 20, description: 'Kredit yang mengalami keterlambatan 121-180 hari' },
            { name: 'Kredit Macet', nilai: 10, description: 'Kredit yang mengalami keterlambatan lebih dari 180 hari' }
        ],
        'Capacity': [
            { name: 'Sangat Mampu', nilai: 50, description: 'Kemampuan membayar sangat baik' },
            { name: 'Mampu', nilai: 40, description: 'Kemampuan membayar baik' },
            { name: 'Cukup Mampu', nilai: 30, description: 'Kemampuan membayar cukup' },
            { name: 'Kurang Mampu', nilai: 20, description: 'Kemampuan membayar kurang' },
            { name: 'Tidak Mampu', nilai: 10, description: 'Kemampuan membayar sangat kurang' }
        ],
        'Capital': [
            { name: 'Modal Sangat Kuat', nilai: 50, description: 'Modal usaha sangat memadai' },
            { name: 'Modal Kuat', nilai: 40, description: 'Modal usaha memadai' },
            { name: 'Modal Cukup', nilai: 30, description: 'Modal usaha cukup memadai' },
            { name: 'Modal Kurang', nilai: 20, description: 'Modal usaha kurang memadai' },
            { name: 'Modal Lemah', nilai: 10, description: 'Modal usaha tidak memadai' }
        ],
        'Collateral': [
            { name: 'Agunan Sangat Memadai', nilai: 50, description: 'Nilai agunan sangat memadai' },
            { name: 'Agunan Memadai', nilai: 40, description: 'Nilai agunan memadai' },
            { name: 'Agunan Cukup', nilai: 30, description: 'Nilai agunan cukup memadai' },
            { name: 'Agunan Kurang', nilai: 20, description: 'Nilai agunan kurang memadai' },
            { name: 'Agunan Tidak Memadai', nilai: 10, description: 'Nilai agunan tidak memadai' }
        ],
        'Condition': [
            { name: 'Kondisi Sangat Baik', nilai: 50, description: 'Kondisi ekonomi sangat mendukung' },
            { name: 'Kondisi Baik', nilai: 40, description: 'Kondisi ekonomi mendukung' },
            { name: 'Kondisi Cukup', nilai: 30, description: 'Kondisi ekonomi cukup mendukung' },
            { name: 'Kondisi Kurang', nilai: 20, description: 'Kondisi ekonomi kurang mendukung' },
            { name: 'Kondisi Buruk', nilai: 10, description: 'Kondisi ekonomi tidak mendukung' }
        ]
    };

    // Initialize auto-suggestion
    document.addEventListener('DOMContentLoaded', function() {
        const parameterInput = document.getElementById('parameter_name');
        const suggestionsDiv = document.getElementById('suggestions');
        const subCriteriaName = '{{ $subCriteria->nama }}';
        
        // Show suggestions on focus
        parameterInput.addEventListener('focus', function() {
            showSuggestions();
        });
        
        // Filter suggestions on input
        parameterInput.addEventListener('input', function() {
            showSuggestions(this.value);
        });
        
        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!parameterInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
                suggestionsDiv.classList.add('hidden');
            }
        });
        
        function showSuggestions(filter = '') {
            const suggestions = commonParameters[subCriteriaName] || [];
            const filteredSuggestions = suggestions.filter(param => 
                param.name.toLowerCase().includes(filter.toLowerCase())
            );
            
            if (filteredSuggestions.length > 0) {
                let html = '';
                filteredSuggestions.forEach(param => {
                    html += `
                        <div class="px-4 py-2 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0" 
                             onclick="selectSuggestion('${param.name}', ${param.nilai}, '${param.description}')">
                            <div class="font-medium text-gray-900">${param.name}</div>
                            <div class="text-xs text-gray-500">Nilai: ${param.nilai} - ${param.description}</div>
                        </div>
                    `;
                });
                suggestionsDiv.innerHTML = html;
                suggestionsDiv.classList.remove('hidden');
            } else {
                suggestionsDiv.classList.add('hidden');
            }
        }
    });
    
    // Select suggestion
    function selectSuggestion(name, nilai, description) {
        document.getElementById('parameter_name').value = name;
        document.getElementById('nilai').value = nilai;
        document.getElementById('description').value = description;
        document.getElementById('suggestions').classList.add('hidden');
    }
    
    // Use template
    function useTemplate(type) {
        const templates = {
            'sangat_baik': { name: 'Sangat Baik', nilai: 100, description: 'Parameter dengan kualitas sangat baik' },
            'baik': { name: 'Baik', nilai: 80, description: 'Parameter dengan kualitas baik' },
            'cukup': { name: 'Cukup', nilai: 60, description: 'Parameter dengan kualitas cukup' },
            'kurang': { name: 'Kurang', nilai: 40, description: 'Parameter dengan kualitas kurang' },
            'buruk': { name: 'Buruk', nilai: 20, description: 'Parameter dengan kualitas buruk' }
        };
        
        const template = templates[type];
        if (template) {
            document.getElementById('parameter_name').value = template.name;
            document.getElementById('nilai').value = template.nilai;
            document.getElementById('description').value = template.description;
        }
    }
    
    // Form validation
    document.getElementById('parameterForm').addEventListener('submit', function(e) {
        const parameterName = document.getElementById('parameter_name').value.trim();
        const nilai = document.getElementById('nilai').value;
        const urutan = document.getElementById('urutan').value;
        
        if (parameterName === '') {
            e.preventDefault();
            alert('Nama parameter harus diisi!');
            document.getElementById('parameter_name').focus();
            return false;
        }
        
        if (nilai === '' || parseFloat(nilai) < 0) {
            e.preventDefault();
            alert('Nilai parameter harus diisi dan tidak boleh negatif!');
            document.getElementById('nilai').focus();
            return false;
        }
        
        if (urutan === '' || parseInt(urutan) < 1) {
            e.preventDefault();
            alert('Urutan parameter harus diisi dan minimal 1!');
            document.getElementById('urutan').focus();
            return false;
        }
    });
    
    // Auto-hide alerts
    setTimeout(function() {
        const alerts = document.querySelectorAll('.bg-red-50');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
</script>
@endpush