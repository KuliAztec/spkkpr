@extends('layouts.superadmin')

@section('title', 'Laporan Evaluasi')
@section('page-title', 'Laporan Hasil Evaluasi')

@section('content')
<div class="mb-6">
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('super-admin.reports.index') }}" class="text-blue-600 hover:text-blue-800">
                    Laporan
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-gray-500">Evaluasi</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Laporan Evaluasi Kredit</h2>
            <p class="text-gray-600 mt-1">Daftar hasil evaluasi kelayakan kredit customer</p>
        </div>
        <div class="flex space-x-3">
            {{-- <button onclick="window.print()" 
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print --}}
            </button>
            <a href="{{ route('super-admin.reports.export') }}?type=evaluations" 
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export
            </a>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Laporan</h3>
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Evaluator</label>
            <select name="evaluator" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Evaluator</option>
                <!-- Add evaluator options dynamically -->
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="md:col-span-4 flex justify-end space-x-3">
            <a href="{{ route('super-admin.reports.evaluations') }}" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md">
                Reset
            </a>
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                Terapkan Filter
            </button>
        </div>
    </form>
</div>

<!-- Evaluations Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Hasil Evaluasi</h3>
    </div>
    
    @if($evaluations->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evaluator</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ranking</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($evaluations as $evaluation)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div>
                            <div class="text-sm font-medium text-gray-900">
                                {{ $evaluation->customer->name ?? 'N/A' }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $evaluation->customer->email ?? 'N/A' }}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $evaluation->evaluator->name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $evaluation->total_score ? number_format($evaluation->total_score, 4) : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $evaluation->ranking ?? '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $evaluation->status === 'approved' ? 'bg-green-100 text-green-800' : 
                               ($evaluation->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($evaluation->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $evaluation->evaluated_at ? $evaluation->evaluated_at->format('d M Y H:i') : $evaluation->created_at->format('d M Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="#" class="text-blue-600 hover:text-blue-900">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Pagination if needed -->
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $evaluations->links() }}
    </div>
    @else
    <div class="px-6 py-12 text-center">
        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada data evaluasi</h3>
        <p class="text-gray-500">Data evaluasi akan muncul di sini setelah ada evaluasi yang dilakukan.</p>
    </div>
    @endif
</div>
@endsection