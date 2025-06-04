@extends('layouts.superadmin')

@section('title', 'Sub Kriteria - ' . $criteria->nama)
@section('page-title', 'Sub Kriteria: ' . $criteria->nama)

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('super-admin.criteria.index') }}" class="text-blue-600 hover:text-blue-800">
                            Kriteria
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
            <h2 class="text-xl font-semibold text-gray-800">Sub Kriteria: {{ $criteria->nama }}</h2>
            <p class="text-gray-600 mt-1">Kelola sub kriteria untuk {{ $criteria->nama }} ({{ $criteria->kode }})</p>
        </div>
        <a href="{{ route('super-admin.criteria.sub-criteria.create', $criteria) }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Sub Kriteria
        </a>
    </div>
</div>

<!-- Informasi Kriteria -->
<div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-blue-800">Informasi Kriteria</h3>
            <div class="mt-2 text-sm text-blue-700">
                <p><strong>Kode:</strong> {{ $criteria->kode }}</p>
                <p><strong>Nama:</strong> {{ $criteria->nama }}</p>
                <p><strong>Deskripsi:</strong> {{ $criteria->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                <p><strong>Status:</strong> {{ $criteria->is_active ? 'Aktif' : 'Tidak Aktif' }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kode
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nama Sub Kriteria
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Bobot
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($subCriterias as $subCriteria)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $subCriteria->kode }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $subCriteria->nama }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($subCriteria->deskripsi, 60) }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ number_format($subCriteria->bobot, 4) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $subCriteria->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $subCriteria->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('super-admin.criteria.sub-criteria.parameters.index', [$criteria, $subCriteria]) }}" 
                               class="btn btn-sm btn-info">
                                <i class="fas fa-cog"></i> Parameter
                            </a>
                            <a href="{{ route('super-admin.criteria.sub-criteria.edit', [$criteria, $subCriteria]) }}" 
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('super-admin.criteria.sub-criteria.destroy', [$criteria, $subCriteria]) }}" 
                                  method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Belum ada sub kriteria. <a href="{{ route('super-admin.criteria.sub-criteria.create', $criteria) }}" class="text-blue-600">Tambah sub kriteria</a> pertama.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    <a href="{{ route('super-admin.criteria.index') }}" 
       class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md">
        ← Kembali ke Daftar Kriteria
    </a>
</div>
@endsection