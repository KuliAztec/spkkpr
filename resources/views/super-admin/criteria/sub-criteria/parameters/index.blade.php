@extends('layouts.superadmin')

@section('title', 'Parameter ' . $subCriteria->nama)

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-sliders-h text-blue-600 mr-3"></i>
                Parameter {{ $subCriteria->nama }}
            </h1>
            <nav class="flex mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('super-admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route('super-admin.criteria.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Kriteria</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route('super-admin.criteria.sub-criteria.index', $criteria) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">{{ $criteria->nama }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $subCriteria->nama }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <a href="{{ route('super-admin.criteria.sub-criteria.index', $criteria) }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <a href="{{ route('super-admin.criteria.sub-criteria.parameters.create', [$criteria, $subCriteria]) }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-plus mr-2"></i> Tambah Parameter
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md mb-6" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm"><strong>Berhasil!</strong> {{ session('success') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button" onclick="this.parentElement.parentElement.parentElement.parentElement.remove()" class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md mb-6" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm"><strong>Error!</strong> {{ session('error') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button" onclick="this.parentElement.parentElement.parentElement.parentElement.remove()" class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white overflow-hidden shadow rounded-lg border-l-4 border-blue-400">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-list text-2xl text-gray-400"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Parameter</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $parameters->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg border-l-4 border-green-400">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-2xl text-gray-400"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Parameter Aktif</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $parameters->where('is_active', true)->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg border-l-4 border-indigo-400">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-weight text-2xl text-gray-400"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Bobot Sub Kriteria</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($subCriteria->bobot ?? 0, 3) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg border-l-4 border-yellow-400">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-trophy text-2xl text-gray-400"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Nilai Tertinggi</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $parameters->max('nilai') ?? 0 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sub Criteria Info -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="bg-blue-600 px-6 py-4 rounded-t-lg">
            <div class="flex items-center">
                <i class="fas fa-info-circle text-white text-lg mr-3"></i>
                <div>
                    <h3 class="text-lg font-medium text-white">Informasi Sub Kriteria</h3>
                    <p class="text-blue-100 text-sm">{{ $criteria->nama }} → {{ $subCriteria->nama }}</p>
                </div>
            </div>
        </div>
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nama Kriteria</dt>
                    <dd class="text-sm text-gray-900">{{ $criteria->nama }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Sub Kriteria</dt>
                    <dd class="text-sm text-gray-900">{{ $subCriteria->nama }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Total Parameter</dt>
                    <dd class="text-sm">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $parameters->count() }} Parameter
                        </span>
                    </dd>
                </div>
            </div>
        </div>
    </div>

    <!-- Parameters Table -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-table text-blue-600 mr-2"></i>Daftar Parameter
                </h3>
                <div class="relative inline-block text-left">
                    <button type="button" onclick="toggleDropdown()" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="menu-button" aria-expanded="true" aria-haspopup="true">
                        <i class="fas fa-cog mr-2"></i>
                        Aksi
                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div id="dropdown-menu" class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="py-1" role="none">
                            <a href="{{ route('super-admin.criteria.sub-criteria.parameters.create', [$criteria, $subCriteria]) }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem">
                                <i class="fas fa-plus w-4 mr-2"></i>Tambah Parameter
                            </a>
                            <hr class="border-gray-200">
                            <a href="{{ route('super-admin.criteria.index') }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem">
                                <i class="fas fa-list w-4 mr-2"></i>Kelola Kriteria
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4">
            @if($parameters->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="parametersTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-12">#</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-20">Urutan</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-left">Nama Parameter</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-left">Deskripsi</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-24">Nilai</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-24">Status</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($parameters as $index => $parameter)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $parameter->urutan }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center">
                                                <i class="fas fa-tag text-white text-sm"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $parameter->parameter_name }}</div>
                                            <div class="text-sm text-gray-500">Parameter {{ $loop->iteration }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs">
                                        @if($parameter->description)
                                            <span title="{{ $parameter->description }}">
                                                {{ Str::limit($parameter->description, 60) }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 italic">Tidak ada deskripsi</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        {{ number_format($parameter->nilai, 0) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($parameter->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fas fa-times-circle mr-1"></i>Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex justify-center items-center space-x-1">
                                        <!-- View Button -->
                                        <button type="button" 
                                                onclick="viewParameter('{{ $parameter->id }}', '{{ addslashes($parameter->parameter_name) }}', '{{ addslashes($parameter->description ?? '') }}', '{{ $parameter->nilai }}', '{{ $parameter->urutan }}', {{ $parameter->is_active ? 'true' : 'false' }})"
                                                class="inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150"
                                                title="Lihat Detail Parameter">
                                            <i class="fas fa-eye w-3 h-3"></i>
                                        </button>
                                        
                                        <!-- Edit Button -->
                                        <a href="{{ route('super-admin.criteria.sub-criteria.parameters.edit', [$criteria, $subCriteria, $parameter]) }}" 
                                           class="inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition ease-in-out duration-150"
                                           title="Edit Parameter">
                                            <i class="fas fa-edit w-3 h-3"></i>
                                        </a>
                                        
                                        <!-- Delete Button -->
                                        <button type="button" 
                                                class="inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition ease-in-out duration-150"
                                                title="Hapus Parameter"
                                                onclick="deleteParameter('{{ $parameter->id }}', '{{ addslashes($parameter->parameter_name) }}')">
                                            <i class="fas fa-trash w-3 h-3"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Table Footer -->
                <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200">
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-2"></i>
                        <span>Menampilkan {{ $parameters->count() }} parameter</span>
                    </div>
                    <a href="{{ route('super-admin.criteria.sub-criteria.parameters.create', [$criteria, $subCriteria]) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-plus mr-2"></i> Tambah Parameter
                    </a>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="mb-4">
                        <i class="fas fa-clipboard-list text-6xl text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Parameter</h3>
                    <p class="text-gray-500 mb-6 max-w-md mx-auto">
                        Sub kriteria <strong>"{{ $subCriteria->nama }}"</strong> belum memiliki parameter evaluasi.<br>
                        Tambahkan parameter untuk mulai melakukan penilaian yang akurat.
                    </p>
                    <div class="space-y-4">
                        <a href="{{ route('super-admin.criteria.sub-criteria.parameters.create', [$criteria, $subCriteria]) }}" 
                           class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-plus mr-2"></i> Buat Parameter Pertama
                        </a>
                        <div>
                            <p class="text-sm text-gray-400">
                                Contoh parameter untuk evaluasi kredit: Kredit Lancar, Kredit Bermasalah, dll.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-between items-center mt-6">
        <a href="{{ route('super-admin.criteria.sub-criteria.index', $criteria) }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Sub Kriteria
        </a>
        
        <div class="flex space-x-3">
            <a href="{{ route('super-admin.criteria.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <i class="fas fa-list mr-2"></i> Daftar Kriteria
            </a>
            <a href="{{ route('super-admin.dashboard') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-home mr-2"></i> Dashboard
            </a>
        </div>
    </div>
</div>

<!-- View Parameter Modal -->
<div id="viewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 lg:w-1/3 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Detail Parameter</h3>
                <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-500">Nama Parameter</label>
                    <p id="viewParameterName" class="text-sm text-gray-900 font-medium"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Deskripsi</label>
                    <p id="viewParameterDescription" class="text-sm text-gray-900"></p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Nilai</label>
                        <p id="viewParameterNilai" class="text-sm text-gray-900 font-medium"></p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Urutan</label>
                        <p id="viewParameterUrutan" class="text-sm text-gray-900 font-medium"></p>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Status</label>
                    <p id="viewParameterStatus" class="text-sm"></p>
                </div>
            </div>
            <div class="flex justify-end mt-6">
                <button onclick="closeViewModal()" class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Konfirmasi Hapus</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Yakin ingin menghapus parameter <strong id="parameterName"></strong>? 
                    Data yang dihapus tidak dapat dikembalikan.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <div class="flex space-x-3 justify-center">
                    <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        <i class="fas fa-times mr-1"></i> Batal
                    </button>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <i class="fas fa-trash mr-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Toggle dropdown
function toggleDropdown() {
    document.getElementById('dropdown-menu').classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('dropdown-menu');
    const button = document.getElementById('menu-button');
    
    if (!button.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.classList.add('hidden');
    }
});

// View parameter function
function viewParameter(id, name, description, nilai, urutan, isActive) {
    document.getElementById('viewParameterName').textContent = name;
    document.getElementById('viewParameterDescription').textContent = description || 'Tidak ada deskripsi';
    document.getElementById('viewParameterNilai').textContent = nilai;
    document.getElementById('viewParameterUrutan').textContent = urutan;
    
    const statusElement = document.getElementById('viewParameterStatus');
    if (isActive) {
        statusElement.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"><i class="fas fa-check-circle mr-1"></i>Aktif</span>';
    } else {
        statusElement.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800"><i class="fas fa-times-circle mr-1"></i>Tidak Aktif</span>';
    }
    
    document.getElementById('viewModal').classList.remove('hidden');
}

// Close view modal
function closeViewModal() {
    document.getElementById('viewModal').classList.add('hidden');
}

// Delete parameter function
function deleteParameter(parameterId, parameterName) {
    document.getElementById('parameterName').textContent = parameterName;
    document.getElementById('deleteForm').action = '{{ route("super-admin.criteria.sub-criteria.parameters.destroy", [$criteria, $subCriteria, ":id"]) }}'.replace(':id', parameterId);
    document.getElementById('deleteModal').classList.remove('hidden');
}

// Close modal
function closeModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50');
        alerts.forEach(function(alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 500);
        });
    }, 5000);
});

// Close modals when clicking outside
document.getElementById('viewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeViewModal();
    }
});

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endpush