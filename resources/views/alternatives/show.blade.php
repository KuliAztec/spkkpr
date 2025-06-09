@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Detail Nasabah</h1>
        <div class="flex space-x-3">
            <a href="{{ route('alternatives.parameters', $alternative) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Kelola Parameter
            </a>
            <a href="{{ route('alternatives.edit', $alternative) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>
            <a href="{{ route('alternatives.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Basic Info -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Nasabah</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $alternative->code }}</p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Kode</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $alternative->code }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Nama</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $alternative->name }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $alternative->email ?? 'Tidak ada' }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Telepon</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $alternative->phone ?? 'Tidak ada' }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $alternative->address ?? 'Tidak ada' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- AHP Results -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Hasil Penilaian AHP</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Skor dan ranking berdasarkan kriteria</p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Skor Final</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <span class="text-lg font-semibold text-blue-600">
                                {{ $alternative->final_score > 0 ? number_format($alternative->final_score, 4) : 'Belum dihitung' }}
                            </span>
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Ranking</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if($alternative->rank > 0)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $alternative->rank <= 3 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    #{{ $alternative->rank }}
                                </span>
                            @else
                                <span class="text-gray-400">Belum ada ranking</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- Evaluations Detail -->
    @if($alternative->evaluations->count() > 0)
        <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Detail Penilaian</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Nilai untuk setiap sub kriteria</p>
            </div>
            <div class="border-t border-gray-200 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kriteria</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sub Kriteria</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Normalized</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($alternative->evaluations as $evaluation)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $evaluation->subcriteria->criteria->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $evaluation->subcriteria->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-900">
                                    {{ $evaluation->value }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                    {{ number_format($evaluation->normalized_value, 4) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Parameters Information -->
    @if($alternative->parameters->count() > 0)
        <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Parameter</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Parameter yang dipilih untuk setiap sub kriteria</p>
            </div>
            <div class="border-t border-gray-200">
                @php
                    $groupedParams = $alternative->parameters->groupBy('subcriteria.criteria.name');
                @endphp
                
                @foreach($groupedParams as $criteriaName => $params)
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h4 class="text-md font-semibold text-gray-800 mb-3">{{ $criteriaName }}</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($params as $param)
                                <div class="bg-gray-50 p-3 rounded">
                                    <div class="text-sm font-medium text-gray-900">{{ $param->subcriteria->name }}</div>
                                    <div class="text-sm text-blue-600 font-semibold">{{ $param->parameter_name }}</div>
                                    <div class="text-xs text-gray-500">Nilai: {{ $param->nilai }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Parameter Belum Diisi</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>Parameter untuk nasabah ini belum diisi. 
                            <a href="{{ route('alternatives.parameters', $alternative) }}" class="font-medium underline text-yellow-800 hover:text-yellow-900">
                                Klik di sini untuk mengisi parameter.
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
