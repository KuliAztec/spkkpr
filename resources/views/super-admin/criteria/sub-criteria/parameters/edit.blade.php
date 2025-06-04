@extends('layouts.superadmin')

@section('title', 'Edit Parameter - ' . $parameter->parameter_name)

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Parameter</h1>
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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit Parameter</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="mt-4 sm:mt-0">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                <i class="fas fa-edit mr-2"></i>{{ $parameter->parameter_name }}
            </span>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md mb-6" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm"><strong>Berhasil!</strong> {{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

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
                        <i class="fas fa-edit text-blue-600 mr-2"></i>Form Edit Parameter
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Kriteria: <span class="font-medium">{{ $criteria->nama }}</span> → 
                        Sub Kriteria: <span class="font-medium">{{ $subCriteria->nama }}</span>
                    </p>
                </div>
                
                <div class="px-6 py-4">
                    <form action="{{ route('super-admin.criteria.sub-criteria.parameters.update', [$criteria, $subCriteria, $parameter]) }}" method="POST" id="parameterForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Parameter Name & Order Row -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                            <div class="md:col-span-3">
                                <label for="parameter_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Parameter <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('parameter_name') border-red-500 @enderror" 
                                       id="parameter_name" 
                                       name="parameter_name" 
                                       value="{{ old('parameter_name', $parameter->parameter_name) }}" 
                                       placeholder="Masukkan nama parameter"
                                       required>
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
                                       value="{{ old('urutan', $parameter->urutan) }}" 
                                       min="1"
                                       placeholder="1"
                                       required>
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
                                      placeholder="Deskripsi parameter (opsional)">{{ old('description', $parameter->description) }}</textarea>
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
                                       value="{{ old('nilai', $parameter->nilai) }}" 
                                       placeholder="50"
                                       min="0"
                                       required>
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
                                               {{ old('is_active', $parameter->is_active) == '1' ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-2 text-sm text-gray-900">
                                            <i class="fas fa-check-circle text-green-500 mr-1"></i>Aktif
                                        </span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" 
                                               name="is_active" 
                                               value="0" 
                                               {{ old('is_active', $parameter->is_active) == '0' ? 'checked' : '' }}
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
                                    <i class="fas fa-save mr-2"></i> Update Parameter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="lg:col-span-1">
            <!-- Current Parameter Info -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-tag text-blue-600 mr-2"></i>Parameter Saat Ini
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <div class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama Parameter</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-medium">{{ $parameter->parameter_name }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nilai</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ number_format($parameter->nilai, 0) }}
                                </span>
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Urutan</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    #{{ $parameter->urutan }}
                                </span>
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                @if($parameter->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-times-circle mr-1"></i>Tidak Aktif
                                    </span>
                                @endif
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Dibuat</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $parameter->created_at ? $parameter->created_at->format('d/m/Y H:i') : '-' }}
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Terakhir Diubah</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $parameter->updated_at ? $parameter->updated_at->format('d/m/Y H:i') : '-' }}
                            </dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Criteria Info -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>Informasi Hierarki
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
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="px-6 py-4">
                    <h4 class="text-sm font-medium text-yellow-900 mb-3">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Peringatan
                    </h4>
                    <ul class="space-y-2 text-sm text-yellow-800">
                        <li class="flex items-start">
                            <i class="fas fa-info-circle text-yellow-600 mr-2 mt-0.5 flex-shrink-0"></i>
                            <span>Perubahan parameter akan mempengaruhi semua evaluasi yang menggunakan parameter ini</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-info-circle text-yellow-600 mr-2 mt-0.5 flex-shrink-0"></i>
                            <span>Pastikan nilai parameter sesuai dengan skala evaluasi yang digunakan</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-info-circle text-yellow-600 mr-2 mt-0.5 flex-shrink-0"></i>
                            <span>Parameter yang tidak aktif tidak akan muncul dalam form evaluasi</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-6">
        <div class="bg-gray-50 border border-gray-200 rounded-lg px-6 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h4 class="text-sm font-medium text-gray-900">Aksi Cepat</h4>
                    <p class="text-sm text-gray-500">Aksi lain yang dapat dilakukan untuk parameter ini</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('super-admin.criteria.sub-criteria.parameters.index', [$criteria, $subCriteria]) }}" 
                       class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-list mr-2"></i> Lihat Semua Parameter
                    </a>
                    <a href="{{ route('super-admin.criteria.sub-criteria.parameters.create', [$criteria, $subCriteria]) }}" 
                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-plus mr-2"></i> Tambah Parameter Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
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
    
    // Reset form to original values
    document.querySelector('button[type="reset"]').addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm('Yakin ingin mengembalikan form ke nilai awal?')) {
            document.getElementById('parameter_name').value = '{{ $parameter->parameter_name }}';
            document.getElementById('nilai').value = '{{ $parameter->nilai }}';
            document.getElementById('urutan').value = '{{ $parameter->urutan }}';
            document.getElementById('description').value = '{{ $parameter->description }}';
            
            // Reset radio buttons
            const isActive = {{ $parameter->is_active ? 'true' : 'false' }};
            document.querySelector(`input[name="is_active"][value="${isActive ? '1' : '0'}"]`).checked = true;
        }
    });
    
    // Auto-hide alerts
    setTimeout(function() {
        const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
    
    // Highlight changes
    const originalValues = {
        parameter_name: '{{ $parameter->parameter_name }}',
        nilai: '{{ $parameter->nilai }}',
        urutan: '{{ $parameter->urutan }}',
        description: '{{ $parameter->description }}',
        is_active: '{{ $parameter->is_active }}'
    };
    
    function checkChanges() {
        const inputs = ['parameter_name', 'nilai', 'urutan', 'description'];
        
        inputs.forEach(function(inputName) {
            const input = document.getElementById(inputName);
            if (input && input.value !== originalValues[inputName]) {
                input.classList.add('border-yellow-400', 'bg-yellow-50');
            } else if (input) {
                input.classList.remove('border-yellow-400', 'bg-yellow-50');
            }
        });
        
        // Check radio buttons
        const activeRadio = document.querySelector('input[name="is_active"]:checked');
        if (activeRadio && activeRadio.value !== originalValues.is_active) {
            document.querySelectorAll('input[name="is_active"]').forEach(radio => {
                radio.parentElement.classList.add('text-yellow-700');
            });
        } else {
            document.querySelectorAll('input[name="is_active"]').forEach(radio => {
                radio.parentElement.classList.remove('text-yellow-700');
            });
        }
    }
    
    // Add change listeners
    document.getElementById('parameter_name').addEventListener('input', checkChanges);
    document.getElementById('nilai').addEventListener('input', checkChanges);
    document.getElementById('urutan').addEventListener('input', checkChanges);
    document.getElementById('description').addEventListener('input', checkChanges);
    document.querySelectorAll('input[name="is_active"]').forEach(radio => {
        radio.addEventListener('change', checkChanges);
    });
</script>
@endpush