@extends('layouts.superadmin')

@section('title', 'Tambah Sub Kriteria')
@section('page-title', 'Tambah Sub Kriteria: ' . $criteria->nama)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
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
                        <a href="{{ route('super-admin.criteria.sub-criteria.index', $criteria) }}" class="text-blue-600 hover:text-blue-800">
                            {{ $criteria->nama }}
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-500">Tambah Sub Kriteria</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Informasi Kriteria -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <h3 class="text-sm font-medium text-blue-800 mb-2">Kriteria Induk</h3>
        <div class="text-sm text-blue-700">
            <p><strong>{{ $criteria->kode }}</strong> - {{ $criteria->nama }}</p>
            <p class="text-xs mt-1">{{ $criteria->deskripsi }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Form Tambah Sub Kriteria</h2>
            <p class="text-gray-600 mt-1">Isi form di bawah untuk menambah sub kriteria baru</p>
        </div>

        <form action="{{ route('super-admin.criteria.sub-criteria.store', $criteria) }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="kode" class="block text-sm font-medium text-gray-700 mb-2">
                    Kode Sub Kriteria <span class="text-red-500">*</span>
                </label>
                <input type="text" id="kode" name="kode" value="{{ old('kode') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('kode') border-red-500 @enderror" 
                       placeholder="Contoh: {{ $criteria->kode }}1, {{ $criteria->kode }}2, dst..." required>
                @error('kode')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Sub Kriteria <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama') border-red-500 @enderror" 
                       placeholder="Nama sub kriteria..." required>
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('deskripsi') border-red-500 @enderror" 
                          placeholder="Deskripsi sub kriteria...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('super-admin.criteria.sub-criteria.index', $criteria) }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                    Simpan Sub Kriteria
                </button>
            </div>
        </form>
    </div>
</div>
@endsection