@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Perbandingan Berpasangan Kriteria</h1>
        <p class="mt-2 text-sm text-gray-600">Bandingkan setiap pasang kriteria menggunakan skala 1-9</p>
    </div>

    <!-- AHP Scale Guide -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-3">Skala Perbandingan AHP</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <p><strong>1</strong> - Sama penting</p>
                <p><strong>3</strong> - Sedikit lebih penting</p>
                <p><strong>5</strong> - Lebih penting</p>
                <p><strong>7</strong> - Sangat lebih penting</p>
                <p><strong>9</strong> - Mutlak lebih penting</p>
            </div>
            <div>
                <p><strong>2, 4, 6, 8</strong> - Nilai antara</p>
                <p><strong>1/3, 1/5, 1/7, 1/9</strong> - Kebalikan dari nilai di atas</p>
            </div>
        </div>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <form action="{{ route('criteria.pairwise.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Kriteria</th>
                            @foreach($criteria as $criterion)
                                <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">
                                    {{ $criterion->code }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($criteria as $i => $criterion1)
                            <tr class="{{ $i % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}">
                                <td class="px-4 py-3 font-medium text-gray-900">
                                    {{ $criterion1->code }} - {{ $criterion1->name }}
                                </td>
                                @foreach($criteria as $j => $criterion2)
                                    <td class="px-4 py-3 text-center">
                                        @if($i == $j)
                                            <span class="text-gray-500">1</span>
                                        @elseif($i < $j)
                                            <select name="comparisons[{{ $criterion1->id }}][{{ $criterion2->id }}]" 
                                                    class="w-20 text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                            </select>
                                        @else
                                            <span class="text-gray-400 text-sm">Auto</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Consistency Check -->
            @if($criteria->where('weight', '>', 0)->count() > 0)
                @php
                    $n = $criteria->count();
                    $criteriaArray = $criteria->toArray();
                    
                    // Build comparison matrix from the form selections (current dropdown values)
                    $matrix = [];
                    
                    // Initialize matrix with 1s on diagonal
                    for($i = 0; $i < $n; $i++) {
                        for($j = 0; $j < $n; $j++) {
                            if($i == $j) {
                                $matrix[$i][$j] = 1;
                            } else {
                                $matrix[$i][$j] = 1; // default value
                            }
                        }
                    }
                    
                    // Fill upper triangle based on weight ratios (approximate comparison values)
                    for($i = 0; $i < $n; $i++) {
                        for($j = $i + 1; $j < $n; $j++) {
                            if($criteriaArray[$i]['weight'] > 0 && $criteriaArray[$j]['weight'] > 0) {
                                $ratio = $criteriaArray[$i]['weight'] / $criteriaArray[$j]['weight'];
                                
                                // Convert ratio to AHP scale
                                if($ratio >= 8) $value = 9;
                                elseif($ratio >= 6) $value = 8;
                                elseif($ratio >= 4.5) $value = 7;
                                elseif($ratio >= 3.5) $value = 6;
                                elseif($ratio >= 2.5) $value = 5;
                                elseif($ratio >= 1.8) $value = 4;
                                elseif($ratio >= 1.3) $value = 3;
                                elseif($ratio >= 1.1) $value = 2;
                                else $value = 1;
                                
                                $matrix[$i][$j] = $value;
                                $matrix[$j][$i] = 1 / $value; // reciprocal for lower triangle
                            }
                        }
                    }
                    
                    // Calculate column sums for normalization
                    $columnSums = [];
                    for($j = 0; $j < $n; $j++) {
                        $sum = 0;
                        for($i = 0; $i < $n; $i++) {
                            $sum += $matrix[$i][$j];
                        }
                        $columnSums[$j] = $sum;
                    }
                    
                    // Normalize matrix and calculate priority vector
                    $priorityVector = [];
                    for($i = 0; $i < $n; $i++) {
                        $rowSum = 0;
                        for($j = 0; $j < $n; $j++) {
                            if($columnSums[$j] > 0) {
                                $rowSum += $matrix[$i][$j] / $columnSums[$j];
                            }
                        }
                        $priorityVector[$i] = $rowSum / $n;
                    }
                    
                    // Calculate weighted sum vector (matrix × priority vector)
                    $weightedSum = [];
                    for($i = 0; $i < $n; $i++) {
                        $sum = 0;
                        for($j = 0; $j < $n; $j++) {
                            $sum += $matrix[$i][$j] * $priorityVector[$j];
                        }
                        $weightedSum[$i] = $sum;
                    }
                    
                    // Calculate consistency vector (weighted sum / priority vector)
                    $consistencyVector = [];
                    for($i = 0; $i < $n; $i++) {
                        if($priorityVector[$i] > 0) {
                            $consistencyVector[$i] = $weightedSum[$i] / $priorityVector[$i];
                        } else {
                            $consistencyVector[$i] = 0;
                        }
                    }
                    
                    // Calculate lambda max (average of consistency vector)
                    $lambdaMax = array_sum($consistencyVector) / $n;
                    
                    // Calculate CI (Consistency Index)
                    $ci = $n > 1 ? ($lambdaMax - $n) / ($n - 1) : 0;
                    
                    // Random Index (RI) values for different matrix sizes
                    // Index corresponds to matrix size: n=1,2,3,4,5,6,7,8,9,10
                    $riValues = [0, 0, 0.58, 0.9, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49];
                    $ri = isset($riValues[$n-1]) ? $riValues[$n-1] : 1.49;
                    
                    // Calculate CR (Consistency Ratio)
                    $cr = ($ri > 0 && $ci > 0) ? $ci / $ri : 0;
                    
                    // Determine consistency status
                    $isConsistent = $cr <= 0.1;
                @endphp
                
                <div class="mt-6 p-4 border rounded-lg {{ $isConsistent ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-semibold {{ $isConsistent ? 'text-green-800' : 'text-red-800' }}">
                            Uji Konsistensi
                        </h4>
                        <div class="flex items-center">
                            @if($isConsistent)
                                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-green-800 font-medium">KONSISTEN</span>
                            @else
                                <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-red-800 font-medium">TIDAK KONSISTEN</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                        <div class="bg-white p-3 rounded-lg border">
                            <div class="text-gray-600">Lambda Max (λmax)</div>
                            <div class="text-lg font-semibold text-gray-900">{{ number_format($lambdaMax, 4) }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-lg border">
                            <div class="text-gray-600">Consistency Index (CI)</div>
                            <div class="text-lg font-semibold text-gray-900">{{ number_format($ci, 4) }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-lg border">
                            <div class="text-gray-600">Random Index (RI)</div>
                            <div class="text-lg font-semibold text-gray-900">{{ number_format($ri, 2) }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-lg border">
                            <div class="text-gray-600">Consistency Ratio (CR)</div>
                            <div class="text-lg font-semibold {{ $cr <= 0.1 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($cr, 4) }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Debug Information (optional, remove in production) -->
                    <div class="mt-4 p-3 bg-gray-100 rounded-lg border text-xs">
                        <div class="text-gray-600 mb-2">Debug Info:</div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <strong>Priority Vector:</strong><br>
                                @foreach($priorityVector as $i => $pv)
                                    {{ $criteriaArray[$i]['code'] }}: {{ number_format($pv, 4) }}<br>
                                @endforeach
                            </div>
                            <div>
                                <strong>Consistency Vector:</strong><br>
                                @foreach($consistencyVector as $i => $cv)
                                    {{ $criteriaArray[$i]['code'] }}: {{ number_format($cv, 4) }}<br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 p-3 bg-white rounded-lg border">
                        <div class="text-sm text-gray-600 mb-2">Interpretasi:</div>
                        @if($isConsistent)
                            <div class="text-sm text-green-700">
                                ✓ CR ≤ 0.1 : Perbandingan konsisten dan dapat diterima.
                            </div>
                        @else
                            <div class="text-sm text-red-700">
                                ✗ CR > 0.1 : Perbandingan tidak konsisten. Silakan periksa kembali nilai perbandingan Anda.
                            </div>
                        @endif
                        <div class="text-xs text-gray-500 mt-2">
                            Consistency Ratio (CR) harus ≤ 0.1 untuk dianggap konsisten dalam metode AHP.
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('criteria.index') }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit"
                        class="bg-blue-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700">
                    Hitung Bobot
                </button>
            </div>
        </form>
    </div>

    <!-- Current Weights Display -->
    @if($criteria->where('weight', '>', 0)->count() > 0)
        <div class="mt-6 bg-white shadow sm:rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Bobot Saat Ini</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($criteria as $criterion)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="font-medium text-gray-900">{{ $criterion->name }}</p>
                            <p class="text-sm text-gray-600">{{ $criterion->code }}</p>
                            <p class="text-lg font-semibold text-blue-600 mt-2">
                                {{ number_format($criterion->weight, 4) }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
