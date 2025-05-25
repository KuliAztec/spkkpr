@extends('layouts.superadmin')

@section('title', 'Data Customer')
@section('page-title', 'Laporan Data Customer')

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
                    <span class="text-gray-500">Customer</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Data Customer</h2>
            <p class="text-gray-600 mt-1">Informasi lengkap customer dan riwayat evaluasi</p>
        </div>
        <div class="flex space-x-3">
            {{-- <button onclick="window.print()" 
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print --}}
            </button>
            <a href="{{ route('super-admin.reports.export') }}?type=customers" 
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
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Data</h3>
    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari nama atau email..." 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status Evaluasi</label>
            <select name="evaluation_status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Status</option>
                <option value="evaluated" {{ request('evaluation_status') == 'evaluated' ? 'selected' : '' }}>Sudah Dievaluasi</option>
                <option value="not_evaluated" {{ request('evaluation_status') == 'not_evaluated' ? 'selected' : '' }}>Belum Dievaluasi</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Periode Registrasi</label>
            <select name="period" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Periode</option>
                <option value="this_month" {{ request('period') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="last_month" {{ request('period') == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
                <option value="this_year" {{ request('period') == 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
            </select>
        </div>
        <div class="md:col-span-3 flex justify-end space-x-3">
            <a href="{{ route('super-admin.reports.customers') }}" 
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

<!-- Customers Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Daftar Customer</h3>
    </div>
    
    @if($customers->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pekerjaan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendapatan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evaluasi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bergabung</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($customers as $customer)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-700">
                                        {{ substr($customer->name, 0, 2) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                                <div class="text-sm text-gray-500">ID: #{{ $customer->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $customer->email }}</div>
                        <div class="text-sm text-gray-500">{{ $customer->phone ?: '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $customer->job ?: '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $customer->income ? 'Rp ' . number_format($customer->income, 0, ',', '.') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($customer->evaluations->count() > 0)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $customer->evaluations->count() }} Evaluasi
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Belum Dievaluasi
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $customer->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Detail</a>
                        <a href="#" class="text-green-600 hover:text-green-900">Evaluasi</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Pagination if needed -->
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $customers->links() }}
    </div>
    @else
    <div class="px-6 py-12 text-center">
        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada data customer</h3>
        <p class="text-gray-500">Data customer akan muncul di sini setelah ada customer yang terdaftar.</p>
    </div>
    @endif
</div>
@endsection