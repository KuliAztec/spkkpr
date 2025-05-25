@extends('layouts.superadmin')

@section('title', 'Atur Bobot Sub Kriteria')
@section('page-title', 'Atur Bobot Sub Kriteria: ' . $criteria->nama)

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('super-admin.ahp-weights.index') }}" class="text-blue-600 hover:text-blue-800">
                        Bobot AHP
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-500">{{ $criteria->nama }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <h2 class="text-xl font-semibold text-gray-800">Matriks Perbandingan Sub Kriteria</h2>
        <p class="text-gray-600 mt-1">Bandingkan sub kriteria untuk {{ $criteria->nama }} ({{ $criteria->kode }})</p>
    </div>

    <!-- Info Kriteria -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-medium text-blue-800">Kriteria: {{ $criteria->nama }}</h3>
                <p class="text-xs text-blue-600 mt-1">{{ $criteria->deskripsi }}</p>
            </div>
            <div class="text-right text-sm text-blue-700">
                <div>Bobot Kriteria: <strong>{{ number_format($criteria->bobot, 4) }}</strong></div>
                <div>{{ $subCriterias->count() }} Sub Kriteria</div>
            </div>
        </div>
    </div>

    <!-- Panduan Skala AHP -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
        <h3 class="text-sm font-medium text-yellow-800 mb-3">Panduan Skala Perbandingan AHP</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 text-sm text-yellow-700">
            <div><strong>1:</strong> Sama penting</div>
            <div><strong>3:</strong> Lebih penting</div>
            <div><strong>5:</strong> Mutlak lebih penting</div>
            <div><strong>7:</strong> Sangat mutlak lebih penting</div>
            <div><strong>9:</strong> Ekstrem lebih penting</div>
            <div><strong>2,4,6,8:</strong> Nilai antara</div>
        </div>
        <p class="text-xs text-yellow-600 mt-2">
            <strong>Catatan:</strong> Consistency Ratio (CR) harus ≤ 0.1 untuk hasil yang konsisten
        </p>
    </div>

    @if($subCriterias->count() < 2)
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Perhatian</h3>
                <div class="mt-2 text-sm text-red-700">
                    <p>Kriteria ini memiliki kurang dari 2 sub kriteria aktif. Minimal 2 sub kriteria diperlukan untuk perbandingan AHP.</p>
                </div>
                <div class="mt-4">
                    <a href="{{ route('super-admin.criteria.sub-criteria.index', $criteria) }}" 
                       class="bg-red-100 hover:bg-red-200 text-red-800 px-3 py-1 rounded text-sm">
                        Kelola Sub Kriteria
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Form Matriks Sub Kriteria -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Matriks Perbandingan Sub Kriteria</h3>
            <p class="text-sm text-gray-600 mt-1">Isi nilai perbandingan untuk setiap pasangan sub kriteria</p>
        </div>

        <form action="{{ route('super-admin.ahp-weights.sub-criteria.store', $criteria) }}" method="POST">
            @csrf
            
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase border border-gray-300">
                                    Sub Kriteria
                                </th>
                                @foreach($subCriterias as $subCriteria)
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase border border-gray-300">
                                    {{ $subCriteria->kode }}
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subCriterias as $i => $sub1)
                            <tr class="{{ $i % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-4 py-3 font-medium text-gray-900 border border-gray-300">
                                    <div>
                                        <div class="font-semibold">{{ $sub1->kode }}</div>
                                        <div class="text-xs text-gray-600">{{ Str::limit($sub1->nama, 25) }}</div>
                                    </div>
                                </td>
                                @foreach($subCriterias as $j => $sub2)
                                <td class="px-2 py-3 text-center border border-gray-300">
                                    @if($i == $j)
                                        <!-- Diagonal = 1 -->
                                        <span class="inline-flex items-center justify-center w-16 h-8 bg-gray-200 text-gray-700 text-sm font-medium rounded">
                                            1
                                        </span>
                                    @elseif($i < $j)
                                        <!-- Upper triangle - input field -->
                                        <select name="comparison_{{ $i }}_{{ $j }}" 
                                                class="w-20 px-2 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                onchange="updateSubMatrix({{ $i }}, {{ $j }}, this.value)">
                                            @for($k = 1; $k <= 9; $k++)
                                                <option value="{{ $k }}" {{ (isset($matrix[$i][$j]) && $matrix[$i][$j] == $k) ? 'selected' : '' }}>
                                                    {{ $k }}
                                                </option>
                                            @endfor
                                        </select>
                                    @else
                                        <!-- Lower triangle - calculated automatically -->
                                        <span id="sub_calculated_{{ $i }}_{{ $j }}" class="inline-flex items-center justify-center w-16 h-8 bg-gray-100 text-gray-600 text-sm rounded">
                                            {{ isset($matrix[$i][$j]) ? number_format($matrix[$i][$j], 2) : '1.00' }}
                                        </span>
                                    @endif
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Preview Hasil Sub Kriteria -->
                @if(isset($existingMatrix) && $existingMatrix)
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 mb-3">Bobot Sub Kriteria</h4>
                        <div class="space-y-2">
                            @foreach($subCriterias as $i => $subCriteria)
                            <div class="flex justify-between items-center">
                                <div class="flex-1">
                                    <span class="text-sm font-medium">{{ $subCriteria->kode }}</span>
                                    <div class="text-xs text-gray-500">{{ Str::limit($subCriteria->nama, 30) }}</div>
                                </div>
                                <span class="text-sm bg-blue-100 text-blue-800 px-2 py-1 rounded ml-2">
                                    {{ isset($existingMatrix->weights[$i]) ? number_format($existingMatrix->weights[$i], 4) : '0.0000' }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 mb-3">Status Konsistensi</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium">Consistency Ratio:</span>
                                <span class="text-sm font-mono">{{ number_format($existingMatrix->consistency_ratio, 4) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium">Status:</span>
                                <span class="px-2 py-1 rounded text-xs font-medium
                                    {{ $existingMatrix->is_valid ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $existingMatrix->is_valid ? 'Konsisten' : 'Tidak Konsisten' }}
                                </span>
                            </div>
                            @if(!$existingMatrix->is_valid)
                            <div class="text-xs text-red-600 bg-red-50 p-2 rounded">
                                ⚠️ CR > 0.1 menunjukkan inkonsistensi. Harap review kembali perbandingan Anda.
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between">
                <a href="{{ route('super-admin.ahp-weights.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md">
                    Kembali
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                    Hitung & Simpan Bobot
                </button>
            </div>
        </form>
    </div>
    @endif
</div>

<script>
function updateSubMatrix(i, j, value) {
    const reciprocal = 1 / parseFloat(value);
    const reciprocalElement = document.getElementById(`sub_calculated_${j}_${i}`);
    if (reciprocalElement) {
        reciprocalElement.textContent = reciprocal.toFixed(2);
    }
}

// Initialize matrix on page load
document.addEventListener('DOMContentLoaded', function() {
    @if($subCriterias->count() >= 2)
        @foreach($subCriterias as $i => $sub1)
            @foreach($subCriterias as $j => $sub2)
                @if($i < $j)
                    const subSelect_{{ $i }}_{{ $j }} = document.querySelector('select[name="comparison_{{ $i }}_{{ $j }}"]');
                    if (subSelect_{{ $i }}_{{ $j }}) {
                        updateSubMatrix({{ $i }}, {{ $j }}, subSelect_{{ $i }}_{{ $j }}.value);
                    }
                @endif
            @endforeach
        @endforeach
    @endif
});
</script>
@endsection