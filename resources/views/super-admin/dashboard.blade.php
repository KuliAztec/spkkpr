@extends('layouts.superadmin')

@section('title', 'Super Admin Dashboard')
@section('page-title', 'Dashboard Super Admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Nasabah -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-4.67a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Nasabah</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $totalCustomers ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Total Evaluasi -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Evaluasi</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $totalEvaluations ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Kredit Disetujui -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Kredit Disetujui</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $approvedLoans ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Total User -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total User</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $totalUsers ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Evaluations -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Evaluasi Terbaru</h3>
            <div class="space-y-4">
                @forelse($recentEvaluations ?? [] as $evaluation)
                <div class="flex items-center justify-between border-b pb-2">
                    <div>
                        <p class="font-medium text-gray-900">{{ $evaluation->customer_name ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">{{ $evaluation->created_at ?? 'N/A' }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full 
                        {{ ($evaluation->status ?? '') === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $evaluation->status ?? 'Pending' }}
                    </span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">Belum ada evaluasi</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Sistem</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Kriteria AHP</span>
                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                        {{ $totalCriteria ?? 5 }} Kriteria
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Sub Kriteria</span>
                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                        {{ $totalSubCriteria ?? 15 }} Sub Kriteria
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Bobot AHP</span>
                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">
                        {{ $ahpWeightsStatus ?? 'Perlu Konfigurasi' }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">User Aktif</span>
                    <span class="px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded-full">
                        {{ $activeUsers ?? 0 }} User
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection