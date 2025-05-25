@extends('layouts.superadmin')

@section('title', 'Atur Bobot Kriteria')
@section('page-title', 'Atur Bobot Kriteria AHP')

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
                        <span class="text-gray-500">Atur Bobot Kriteria</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <h2 class="text-xl font-semibold text-gray-800">Matriks Perbandingan Berpasangan - Kriteria</h2>
        <p class="text-gray-600 mt-1">Bandingkan setiap pasangan kriteria untuk menentukan bobot AHP</p>
    </div>

    <!-- Panduan Skala AHP -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <h3 class="text-sm font-medium text-blue-800 mb-3">Panduan Skala Perbandingan AHP</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 text-sm text-blue-700">
            <div><strong>1:</strong> Sama penting</div>
            <div><strong>3:</strong> Lebih penting</div>
            <div><strong>5:</strong> Mutlak lebih penting</div>
            <div><strong>7:</strong> Sangat mutlak lebih penting</div>
            <div><strong>9:</strong> Ekstrem lebih penting</div>
            <div><strong>2,4,6,8:</strong> Nilai antara</div>
        </div>
        <p class="text-xs text-blue-600 mt-2">
            <strong>Catatan:</strong> Consistency Ratio (CR) harus ≤ 0.1 untuk hasil yang konsisten
        </p>
    </div>

    <!-- Form Matriks -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Matriks Perbandingan</h3>
            <p class="text-sm text-gray-600 mt-1">Isi nilai perbandingan untuk setiap pasangan kriteria</p>
        </div>

        <form action="{{ route('super-admin.ahp-weights.criteria.store') }}" method="POST">
            @csrf
            
            <div class="p-6">
                <!-- Tabel Matriks -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase border border-gray-300">
                                    Kriteria
                                </th>
                                @foreach($criterias as $criteria)
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase border border-gray-300">
                                    {{ $criteria->kode }}
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($criterias as $i => $criteria1)
                            <tr class="{{ $i % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-4 py-3 font-medium text-gray-900 border border-gray-300">
                                    <div>
                                        <div class="font-semibold">{{ $criteria1->kode }}</div>
                                        <div class="text-xs text-gray-600">{{ $criteria1->nama }}</div>
                                    </div>
                                </td>
                                @foreach($criterias as $j => $criteria2)
                                <td class="px-2 py-3 text-center border border-gray-300">
                                    @if($i == $j)
                                        <!-- Diagonal = 1 -->
                                        <span class="inline-flex items-center justify-center w-12 h-8 bg-gray-200 text-gray-700 text-sm font-medium rounded">
                                            1
                                        </span>
                                    @elseif($i < $j)
                                        <!-- Upper triangle - input field -->
                                        <select name="comparison_{{ $i }}_{{ $j }}" 
                                                class="w-20 px-2 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                onchange="updateMatrix({{ $i }}, {{ $j }}, this.value)">
                                            @for($k = 1; $k <= 9; $k++)
                                                <option value="{{ $k }}" {{ (isset($matrix[$i][$j]) && $matrix[$i][$j] == $k) ? 'selected' : '' }}>
                                                    {{ $k }}
                                                </option>
                                            @endfor
                                        </select>
                                    @else
                                        <!-- Lower triangle - calculated automatically -->
                                        <span id="calculated_{{ $i }}_{{ $j }}" class="inline-flex items-center justify-center w-12 h-8 bg-gray-100 text-gray-600 text-sm rounded">
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

                <!-- Preview Hasil -->
                @if($existingMatrix)
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 mb-3">Bobot yang Dihasilkan</h4>
                        <div class="space-y-2">
                            @foreach($criterias as $i => $criteria)
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium">{{ $criteria->kode }} - {{ $criteria->nama }}</span>
                                <span class="text-sm bg-blue-100 text-blue-800 px-2 py-1 rounded">
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
                                <span class="text-sm font-medium">Consistency Ratio (CR):</span>
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
</div>

<script>
function updateMatrix(i, j, value) {
    // Update nilai reciprocal di sisi bawah matriks
    const reciprocal = 1 / parseFloat(value);
    const reciprocalElement = document.getElementById(`calculated_${j}_${i}`);
    if (reciprocalElement) {
        reciprocalElement.textContent = reciprocal.toFixed(2);
    }
}

// Initialize matrix on page load
document.addEventListener('DOMContentLoaded', function() {
    // Update all reciprocal values
    @foreach($criterias as $i => $criteria1)
        @foreach($criterias as $j => $criteria2)
            @if($i < $j)
                const select_{{ $i }}_{{ $j }} = document.querySelector('select[name="comparison_{{ $i }}_{{ $j }}"]');
                if (select_{{ $i }}_{{ $j }}) {
                    updateMatrix({{ $i }}, {{ $j }}, select_{{ $i }}_{{ $j }}.value);
                }
            @endif
        @endforeach
    @endforeach
});
</script>
@endsection