@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4">
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Tambah Sub Kriteria</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <h1 class="text-3xl font-bold text-gray-900">Tambah Sub Kriteria Baru</h1>
        <p class="mt-2 text-sm text-gray-600">Masukkan informasi sub kriteria evaluasi baru</p>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <form action="{{ route('subcriteria.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label for="criteria_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Kriteria <span class="text-red-500">*</span>
                    </label>
                    <select name="criteria_id" id="criteria_id" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('criteria_id') border-red-500 @enderror">
                        <option value="">Pilih Kriteria</option>
                        @foreach($criteria as $criterion)
                            <option value="{{ $criterion->id }}" {{ old('criteria_id') == $criterion->id ? 'selected' : '' }}>
                                {{ $criterion->code }} - {{ $criterion->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('criteria_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                        Kode Sub Kriteria <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="code" id="code" required
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('code') border-red-500 @enderror"
                           value="{{ old('code') }}" placeholder="Contoh: C1.1, C1.2, etc."
                           maxlength="10">
                    @error('code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Maksimal 10 karakter</p>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Sub Kriteria <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" required
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                           value="{{ old('name') }}" placeholder="Contoh: Gaji Pokok, Tunjangan, dll."
                           maxlength="255">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                              placeholder="Deskripsi detail tentang sub kriteria ini...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Opsional - Penjelasan lebih detail tentang sub kriteria</p>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('subcriteria.index') }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Batal
                </a>
                <button type="submit"
                        class="bg-blue-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Simpan Sub Kriteria
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-populate code based on criteria selection
document.getElementById('criteria_id').addEventListener('change', function() {
    const criteriaId = this.value;
    const codeInput = document.getElementById('code');
    
    if (criteriaId) {
        const selectedOption = this.options[this.selectedIndex];
        const criteriaCode = selectedOption.text.split(' - ')[0];
        
        // Suggest a code based on criteria code
        if (criteriaCode && !codeInput.value) {
            codeInput.value = criteriaCode + '.1';
        }
    }
});

// Set criteria from URL parameter if exists
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const criteriaParam = urlParams.get('criteria');
    
    if (criteriaParam) {
        const criteriaSelect = document.getElementById('criteria_id');
        criteriaSelect.value = criteriaParam;
        criteriaSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection
