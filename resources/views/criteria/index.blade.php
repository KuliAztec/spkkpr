@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Manajemen Kriteria</h1>
        <div class="flex space-x-3">
            <a href="{{ route('criteria.pairwise') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                Perbandingan Berpasangan
            </a>
            <a href="{{ route('criteria.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Kriteria
            </a>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @forelse($criteria as $criterion)
                <li>
                    <div class="px-4 py-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                    <span class="text-white font-bold">{{ $criterion->code }}</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $criterion->name }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ $criterion->description ?? 'Tidak ada deskripsi' }}
                                </div>
                                <div class="text-xs text-blue-600 mt-1">
                                    {{ $criterion->subcriteria->count() }} Sub Kriteria
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Bobot: {{ $criterion->weight }}
                            </span>
                            <a href="{{ route('criteria.show', $criterion) }}" class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                            <a href="{{ route('criteria.edit', $criterion) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                            <form action="{{ route('criteria.destroy', $criterion) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </div>
                    </div>
                </li>
            @empty
                <li>
                    <div class="px-4 py-8 text-center text-gray-500">
                        Belum ada kriteria. <a href="{{ route('criteria.create') }}" class="text-blue-600 hover:text-blue-800">Tambah kriteria pertama</a>
                    </div>
                </li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
