@extends('layouts.superadmin')

@section('title', 'Bobot AHP')
@section('page-title', 'Kelola Bobot AHP')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Manajemen Bobot AHP</h2>
            <p class="text-gray-600 mt-1">Kelola bobot kriteria dan sub kriteria menggunakan metode AHP</p>
        </div>
    </div>
</div>

<!-- Status Konsistensi -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Bobot Kriteria</h3>
                <p class="text-sm text-gray-600">Status konsistensi matriks kriteria</p>
            </div>
            <div class="text-right">
                @if($criteriaMatrix)
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        {{ $criteriaMatrix->is_valid ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $criteriaMatrix->is_valid ? 'Konsisten' : 'Tidak Konsisten' }}
                    </span>
                    <p class="text-xs text-gray-500 mt-1">
                        CR: {{ number_format($criteriaMatrix->consistency_ratio, 4) }}
                    </p>
                @else
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                        Belum Dikonfigurasi
                    </span>
                @endif
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('super-admin.ahp-weights.criteria') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm">
                Atur Bobot Kriteria
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Bobot Sub Kriteria</h3>
                <p class="text-sm text-gray-600">Atur bobot untuk setiap sub kriteria</p>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-sm text-gray-600 mb-3">Pilih kriteria untuk mengatur bobot sub kriteria:</p>
            <div class="space-y-2">
                @foreach($criterias as $criteria)
                <a href="{{ route('super-admin.ahp-weights.sub-criteria', $criteria) }}" 
                   class="block bg-gray-50 hover:bg-gray-100 px-3 py-2 rounded border text-sm">
                    <span class="font-medium">{{ $criteria->kode }}</span> - {{ $criteria->nama }}
                    <span class="text-xs text-gray-500 ml-2">({{ $criteria->subCriterias->count() }} sub kriteria)</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Tabel Bobot Saat Ini -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Bobot Saat Ini</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kriteria
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Bobot
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Sub Kriteria
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($criterias as $criteria)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $criteria->kode }} - {{ $criteria->nama }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ number_format($criteria->bobot, 4) }}</div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $criteria->bobot * 100 }}%"></div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            @foreach($criteria->subCriterias->take(3) as $sub)
                                <div class="flex justify-between">
                                    <span>{{ $sub->kode }}</span>
                                    <span>{{ number_format($sub->bobot, 4) }}</span>
                                </div>
                            @endforeach
                            @if($criteria->subCriterias->count() > 3)
                                <div class="text-xs text-gray-500">+{{ $criteria->subCriterias->count() - 3 }} lainnya</div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('super-admin.ahp-weights.sub-criteria', $criteria) }}" 
                           class="text-indigo-600 hover:text-indigo-900">Atur Sub Kriteria</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection