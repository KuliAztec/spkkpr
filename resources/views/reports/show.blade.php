@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="mb-8">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('reports.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-purple-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Laporan
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Detail Laporan</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $report->title }}</h1>
                @if($report->description)
                    <p class="mt-2 text-gray-600">{{ $report->description }}</p>
                @endif
                <p class="mt-1 text-sm text-gray-500">Dibuat pada {{ $report->calculation_date->format('d F Y, H:i') }}</p>
            </div>
            <div class="flex space-x-3">
                <div class="relative inline-block text-left">
                    <button onclick="toggleExportMenu()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export
                        <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="exportMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                        <div class="py-1">
                            <a href="{{ route('reports.export', $report) }}?format=excel" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 items-center">
                                <svg class="w-4 h-4 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Export Excel
                            </a>
                            <a href="{{ route('reports.export', $report) }}?format=pdf" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 items-center">
                                <svg class="w-4 h-4 mr-2 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                Export PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-lg text-white">
            <div class="flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <div>
                    <div class="text-2xl font-bold">{{ $report->total_alternatives }}</div>
                    <div class="text-blue-100">Total Alternatif</div>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-lg text-white">
            <div class="flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <div>
                    <div class="text-2xl font-bold">{{ $report->total_criteria }}</div>
                    <div class="text-green-100">Total Kriteria</div>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-6 rounded-lg text-white">
            <div class="flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                <div>
                    <div class="text-2xl font-bold">{{ $report->total_subcriteria }}</div>
                    <div class="text-yellow-100">Sub Kriteria</div>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 rounded-lg text-white">
            <div class="flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                <div>
                    <div class="text-2xl font-bold">{{ $report->alternatives->where('rank', '>', 0)->count() }}</div>
                    <div class="text-purple-100">Ter-rank</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Table -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Hasil Ranking Alternatif</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nasabah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Skor Akhir</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($report->alternatives as $alternative)
                        @php
                            // Status based on final score thresholds
                            if ($alternative->final_score >= 0.1) {
                                $status = 'Layak';
                                $statusClass = 'bg-green-100 text-green-800';
                            } else {
                                $status = 'Tidak Layak';
                                $statusClass = 'bg-red-100 text-red-800';
                            }
                        @endphp
                        <tr class="{{ $alternative->rank <= 3 && $alternative->rank > 0 ? 'bg-green-50' : '' }}">
                            <td class="rank-cell">{{ $alternative->rank > 0 ? $alternative->rank : '-' }}</td>
                            <td>{{ $alternative->code }}</td>
                            <td>{{ $alternative->name }}</td>
                            <td>{{ $alternative->email ?: '-' }}</td>
                            <td>{{ $alternative->phone ?: '-' }}</td>
                            <td class="score-cell">{{ number_format($alternative->final_score, 4) }}</td>
                            <td class="status-cell {{ $statusClass }}">{{ $status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

<script>
function toggleExportMenu() {
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-purple-500 flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ substr($alternative->name, 0, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $alternative->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $alternative->code }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $alternative->email ?? '-' }}</div>
                                <div class="text-sm text-gray-500">{{ $alternative->phone ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-lg font-bold text-purple-600">n-100 text-green-800;
                                    {{ number_format($alternative->final_score, 4) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">100 text-red-800;
                                @if($alternative->rank > 0)
                                    @if($alternative->rank <= 3)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Sangat Layak0;
                                        </span>
                                    @elseif($alternative->rank <= 5)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Layak
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Perlu Review
                                        </span>
                                    @endif
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Tidak Layak
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

<script>
function toggleExportMenu() {
    const menu = document.getElementById('exportMenu');
    menu.classList.toggle('hidden');
}

// Close menu when clicking outside
document.addEventListener('click', function(e) {
    const menu = document.getElementById('exportMenu');
    const button = e.target.closest('button');
    if (!button || !button.onclick) {
        menu.classList.add('hidden');
    }
});
</script>
