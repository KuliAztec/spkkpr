@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <div class="mb-6">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('criteria.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Kriteria
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $criteria->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $criteria->name }}</h1>
                <p class="mt-2 text-sm text-gray-600">Detail informasi kriteria {{ $criteria->code }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('criteria.edit', $criteria) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>
        </div>
    </div>

    <!-- Criteria Information -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Kriteria</h3>
        </div>
        <div class="p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Kode Kriteria</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $criteria->code }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nama Kriteria</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $criteria->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Bobot</dt>
                    <dd class="mt-1 text-lg font-semibold {{ $criteria->weight > 0 ? 'text-green-600' : 'text-gray-400' }}">
                        {{ $criteria->weight > 0 ? number_format($criteria->weight, 4) : 'Belum dihitung' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Jumlah Sub Kriteria</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $criteria->subcriteria->count() }} sub kriteria</dd>
                </div>
                @if($criteria->description)
                <div class="md:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                    <dd class="mt-1 text-gray-900">{{ $criteria->description }}</dd>
                </div>
                @endif
            </dl>
        </div>
    </div>

    <!-- Sub Criteria List -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Sub Kriteria</h3>
            <a href="{{ route('subcriteria.create') }}?criteria={{ $criteria->id }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Sub Kriteria
            </a>
        </div>
        
        @if($criteria->subcriteria->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Bobot</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($criteria->subcriteria as $subcriteria)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $subcriteria->code }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $subcriteria->name }}</div>
                                    @if($subcriteria->description)
                                        <div class="text-sm text-gray-500">{{ Str::limit($subcriteria->description, 50) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="text-sm font-medium {{ $subcriteria->weight > 0 ? 'text-green-600' : 'text-gray-400' }}">
                                        {{ $subcriteria->weight > 0 ? number_format($subcriteria->weight, 4) : 'Belum dihitung' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('subcriteria.show', $subcriteria) }}" 
                                           class="text-blue-600 hover:text-blue-900">Lihat</a>
                                        <a href="{{ route('subcriteria.edit', $subcriteria) }}" 
                                           class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-6 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Sub Kriteria</h3>
                <p class="text-gray-600 mb-4">Tambahkan sub kriteria untuk melengkapi kriteria ini.</p>
                <a href="{{ route('subcriteria.create') }}?criteria={{ $criteria->id }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                    Tambah Sub Kriteria Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
