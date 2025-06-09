@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <div class="mb-6">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('subcriteria.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Sub Kriteria
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $subcriteria->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $subcriteria->name }}</h1>
                <p class="mt-2 text-sm text-gray-600">Detail informasi sub kriteria {{ $subcriteria->code }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('subcriteria.edit', $subcriteria) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>
        </div>
    </div>

    <!-- Subcriteria Information -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6">
        <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Sub Kriteria</h3>
        </div>
        <div class="p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Kode Sub Kriteria</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $subcriteria->code }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nama Sub Kriteria</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $subcriteria->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Kriteria Induk</dt>
                    <dd class="mt-1">
                        <a href="{{ route('criteria.show', $subcriteria->criteria) }}" 
                           class="text-lg font-semibold text-blue-600 hover:text-blue-800">
                            {{ $subcriteria->criteria->code }} - {{ $subcriteria->criteria->name }}
                        </a>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Bobot</dt>
                    <dd class="mt-1 text-lg font-semibold {{ $subcriteria->weight > 0 ? 'text-green-600' : 'text-gray-400' }}">
                        {{ $subcriteria->weight > 0 ? number_format($subcriteria->weight, 4) : 'Belum dihitung' }}
                    </dd>
                </div>
                @if($subcriteria->description)
                <div class="md:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                    <dd class="mt-1 text-gray-900">{{ $subcriteria->description }}</dd>
                </div>
                @endif
            </dl>
        </div>
    </div>

    <!-- Related Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Criteria Information -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Kriteria Induk</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-lg bg-blue-500 flex items-center justify-center mr-4">
                        <span class="text-white font-bold">{{ $subcriteria->criteria->code }}</span>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900">{{ $subcriteria->criteria->name }}</h4>
                        <p class="text-sm text-gray-600">
                            Bobot: {{ $subcriteria->criteria->weight > 0 ? number_format($subcriteria->criteria->weight, 4) : 'Belum dihitung' }}
                        </p>
                    </div>
                </div>
                @if($subcriteria->criteria->description)
                    <p class="text-gray-600 mb-4">{{ $subcriteria->criteria->description }}</p>
                @endif
                <a href="{{ route('criteria.show', $subcriteria->criteria) }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    Lihat Detail Kriteria
                </a>
            </div>
        </div>

        <!-- Evaluation Statistics -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Statistik Evaluasi</h3>
            </div>
            <div class="p-6">
                @php
                    $evaluationCount = $subcriteria->evaluations()->count();
                    $avgValue = $subcriteria->evaluations()->avg('value');
                    $maxValue = $subcriteria->evaluations()->max('value');
                    $minValue = $subcriteria->evaluations()->min('value');
                @endphp
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Evaluasi:</span>
                        <span class="font-semibold">{{ $evaluationCount }}</span>
                    </div>
                    @if($evaluationCount > 0)
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Nilai Rata-rata:</span>
                            <span class="font-semibold">{{ number_format($avgValue, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Nilai Tertinggi:</span>
                            <span class="font-semibold text-green-600">{{ $maxValue }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Nilai Terendah:</span>
                            <span class="font-semibold text-red-600">{{ $minValue }}</span>
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">Belum ada data evaluasi</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
