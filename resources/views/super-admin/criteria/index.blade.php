@extends('layouts.superadmin')

@section('title', 'Kelola Kriteria')
@section('page-title', 'Kelola Kriteria AHP')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Daftar Kriteria</h2>
            <p class="text-gray-600 mt-1">Kelola kriteria untuk evaluasi kredit perumahan</p>
        </div>
        <a href="{{ route('super-admin.criteria.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Kriteria
        </a>
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
                        Nama Kriteria
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Sub Kriteria
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
                @forelse($criterias as $criteria)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $criteria->kode }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $criteria->nama }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($criteria->deskripsi, 50) }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">
                            {{ $criteria->subCriterias->count() }} Sub Kriteria
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ number_format($criteria->bobot, 4) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $criteria->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $criteria->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('super-admin.criteria.sub-criteria.index', $criteria) }}" 
                               class="text-blue-600 hover:text-blue-900">Sub Kriteria</a>
                            <a href="{{ route('super-admin.criteria.edit', $criteria) }}" 
                               class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('super-admin.criteria.destroy', $criteria) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" 
                                        onclick="return confirm('Yakin ingin menghapus kriteria ini?')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Belum ada kriteria. <a href="{{ route('super-admin.criteria.create') }}" class="text-blue-600">Tambah kriteria</a> pertama.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection