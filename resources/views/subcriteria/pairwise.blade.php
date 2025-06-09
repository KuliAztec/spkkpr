@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Perbandingan Berpasangan Sub Kriteria</h1>
        <p class="mt-2 text-sm text-gray-600">
            Kriteria: <strong>{{ $criteria->name }}</strong> - Bandingkan setiap pasang sub kriteria menggunakan skala 1-9
        </p>
    </div>

    <!-- AHP Scale Guide -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
        <h3 class="text-lg font-semibold text-green-900 mb-3">Skala Perbandingan AHP</h3>
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
        <form action="{{ route('subcriteria.pairwise.store', $criteria) }}" method="POST" class="p-6">
            @csrf
            
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Sub Kriteria</th>
                            @foreach($subcriteria as $sub)
                                <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">
                                    {{ $sub->code }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subcriteria as $i => $sub1)
                            <tr class="{{ $i % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}">
                                <td class="px-4 py-3 font-medium text-gray-900">
                                    {{ $sub1->code }} - {{ $sub1->name }}
                                </td>
                                @foreach($subcriteria as $j => $sub2)
                                    <td class="px-4 py-3 text-center">
                                        @if($i == $j)
                                            <span class="text-gray-500">1</span>
                                        @elseif($i < $j)
                                            <select name="comparisons[{{ $sub1->id }}][{{ $sub2->id }}]" 
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

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('subcriteria.index') }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit"
                        class="bg-green-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-green-700">
                    Hitung Bobot
                </button>
            </div>
        </form>
    </div>

    <!-- Current Weights Display -->
    @if($subcriteria->where('weight', '>', 0)->count() > 0)
        <div class="mt-6 bg-white shadow sm:rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Bobot Sub Kriteria Saat Ini</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($subcriteria as $sub)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="font-medium text-gray-900">{{ $sub->name }}</p>
                            <p class="text-sm text-gray-600">{{ $sub->code }}</p>
                            <p class="text-lg font-semibold text-green-600 mt-2">
                                {{ number_format($sub->weight, 4) }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
