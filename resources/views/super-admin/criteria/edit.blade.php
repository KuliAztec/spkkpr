@extends('layouts.superadmin')

@section('title', 'Edit Kriteria')
@section('page-title', 'Edit Kriteria: ' . $criteria->nama)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Form Edit Kriteria</h2>
            <p class="text-gray-600 mt-1">Perbarui informasi kriteria</p>
        </div>

        <form action="{{ route('super-admin.criteria.update', $criteria) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="kode" class="block text-sm font-medium text-gray-700 mb-2">
                    Kode Kriteria <span class="text-red-500">*</span>
                </label>
                <input type="text" id="kode" name="kode" value="{{ old('kode', $criteria->kode) }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('kode') border-red-500 @enderror" 
                       required>
                @error('kode')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kriteria <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $criteria->nama) }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama') border-red-500 @enderror" 
                       required>
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $criteria->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" 
                           {{ old('is_active', $criteria->is_active) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700">Kriteria Aktif</span>
                </label>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('super-admin.criteria.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                    Perbarui Kriteria
                </button>
            </div>
        </form>
    </div>
</div>
@endsection