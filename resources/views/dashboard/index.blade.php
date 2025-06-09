@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            Selamat datang, {{ Auth::user()->name }}!
        </h1>
        <p class="text-gray-600">
            @if(Auth::user()->isSuperAdmin())
                Anda masuk sebagai Super Administrator dengan akses penuh ke sistem.
            @else
                Anda masuk sebagai Administrator dengan akses ke pengelolaan nasabah, evaluasi, dan laporan.
            @endif
        </p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @if(Auth::user()->isSuperAdmin())
            <!-- SuperAdmin sees all stats -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-lg text-white">
                <div class="flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <div>
                        <div class="text-2xl font-bold">{{ $criteria }}</div>
                        <div class="text-blue-100">Kriteria</div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-lg text-white">
                <div class="flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    <div>
                        <div class="text-2xl font-bold">{{ $subcriteria }}</div>
                        <div class="text-green-100">Sub Kriteria</div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Both admin and superadmin see these -->
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-6 rounded-lg text-white">
            <div class="flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <div>
                    <div class="text-2xl font-bold">{{ $alternatives }}</div>
                    <div class="text-yellow-100">Nasabah</div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 rounded-lg text-white">
            <div class="flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <div>
                    <div class="text-2xl font-bold">{{ $evaluations }}</div>
                    <div class="text-purple-100">Evaluasi</div>
                </div>
            </div>
        </div>

        @if(isset($reports))
            <div class="bg-gradient-to-r from-red-500 to-red-600 p-6 rounded-lg text-white">
                <div class="flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <div>
                        <div class="text-2xl font-bold">{{ $reports }}</div>
                        <div class="text-red-100">Laporan</div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Quick Actions and Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
            <div class="space-y-3">
                @if(Auth::user()->isSuperAdmin())
                    <a href="{{ route('criteria.create') }}" 
                       class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="text-blue-800 font-medium">Tambah Kriteria Baru</span>
                    </a>
                    <a href="{{ route('criteria.pairwise') }}" 
                       class="flex items-center p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-green-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span class="text-green-800 font-medium">Hitung Bobot Kriteria</span>
                    </a>
                @endif
                <a href="{{ route('alternatives.create') }}" 
                   class="flex items-center p-3 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span class="text-yellow-800 font-medium">Tambah Nasabah Baru</span>
                </a>
                <a href="{{ route('evaluations.bulk') }}" 
                   class="flex items-center p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    <span class="text-purple-800 font-medium">Evaluasi Massal</span>
                </a>
                <a href="{{ route('evaluations.calculate') }}" 
                   class="flex items-center p-3 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-red-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span class="text-red-800 font-medium">Hitung Skor AHP</span>
                </a>
            </div>
        </div>

        <!-- System Status -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Status Sistem</h2>
            <div class="space-y-4">
                @if(Auth::user()->isSuperAdmin())
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-{{ $criteria > 0 ? 'green' : 'red' }}-500 rounded-full mr-3"></div>
                            <span class="text-gray-700">Konfigurasi Kriteria</span>
                        </div>
                        <span class="text-sm text-gray-500">
                            {{ $criteria > 0 ? 'Siap' : 'Perlu Setup' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-{{ $subcriteria > 0 ? 'green' : 'red' }}-500 rounded-full mr-3"></div>
                            <span class="text-gray-700">Sub Kriteria</span>
                        </div>
                        <span class="text-sm text-gray-500">
                            {{ $subcriteria > 0 ? 'Siap' : 'Perlu Setup' }}
                        </span>
                    </div>
                @endif
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-{{ $alternatives > 0 ? 'green' : 'yellow' }}-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">Data Nasabah</span>
                    </div>
                    <span class="text-sm text-gray-500">
                        {{ $alternatives }} nasabah
                    </span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-{{ $evaluations > 0 ? 'green' : 'yellow' }}-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">Evaluasi</span>
                    </div>
                    <span class="text-sm text-gray-500">
                        {{ $evaluations }} evaluasi
                    </span>
                </div>
                @if(isset($reports))
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-{{ $reports > 0 ? 'green' : 'gray' }}-500 rounded-full mr-3"></div>
                            <span class="text-gray-700">Laporan</span>
                        </div>
                        <span class="text-sm text-gray-500">
                            {{ $reports }} laporan
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Activity or Progress -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Panduan Penggunaan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @if(Auth::user()->isSuperAdmin())
                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="font-semibold text-blue-800 mb-2">1. Setup Kriteria</h3>
                    <p class="text-sm text-gray-600">Buat kriteria dan sub kriteria untuk evaluasi kredit rumah.</p>
                </div>
                <div class="border-l-4 border-green-500 pl-4">
                    <h3 class="font-semibold text-green-800 mb-2">2. Hitung Bobot</h3>
                    <p class="text-sm text-gray-600">Lakukan perbandingan berpasangan untuk menentukan bobot kriteria.</p>
                </div>
            @endif
            <div class="border-l-4 border-yellow-500 pl-4">
                <h3 class="font-semibold text-yellow-800 mb-2">{{ Auth::user()->isSuperAdmin() ? '3' : '1' }}. Input Nasabah</h3>
                <p class="text-sm text-gray-600">Tambahkan data nasabah yang akan dievaluasi untuk kredit rumah.</p>
            </div>
            <div class="border-l-4 border-purple-500 pl-4">
                <h3 class="font-semibold text-purple-800 mb-2">{{ Auth::user()->isSuperAdmin() ? '4' : '2' }}. Evaluasi</h3>
                <p class="text-sm text-gray-600">Lakukan penilaian terhadap setiap nasabah berdasarkan kriteria.</p>
            </div>
            <div class="border-l-4 border-red-500 pl-4">
                <h3 class="font-semibold text-red-800 mb-2">{{ Auth::user()->isSuperAdmin() ? '5' : '3' }}. Analisis</h3>
                <p class="text-sm text-gray-600">Hitung skor AHP dan lihat hasil ranking nasabah terbaik.</p>
            </div>
            <div class="border-l-4 border-gray-500 pl-4">
                <h3 class="font-semibold text-gray-800 mb-2">{{ Auth::user()->isSuperAdmin() ? '6' : '4' }}. Laporan</h3>
                <p class="text-sm text-gray-600">Generate dan export laporan hasil evaluasi kredit.</p>
            </div>
        </div>
    </div>
</div>
@endsection