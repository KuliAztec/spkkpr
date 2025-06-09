@extends('layouts.app')

@section('content')
<div class="max-w-full mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Penilaian AHP</h1>
        <div class="flex space-x-3">
            <button onclick="toggleSidebar()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <span id="sidebar-toggle-text">Sembunyikan Panel</span>
            </button>
            <a href="{{ route('evaluations.bulk') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Penilaian Bulk
            </a>
            <a href="{{ route('evaluations.calculate') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                Hitung AHP
            </a>
            <a href="{{ route('evaluations.results') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Lihat Hasil
            </a>
        </div>
    </div>

    <div class="flex gap-6" id="main-container">
        <!-- Main Content -->
        <div class="transition-all duration-300" id="main-content">
            <!-- Evaluation Matrix -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Matrix Penilaian</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Nilai 1-9 untuk setiap kriteria per nasabah. Klik pada nama nasabah untuk melihat parameter.
                    </p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10 min-w-48">
                                    Nasabah
                                </th>
                                @foreach($criteria as $criterion)
                                    <th colspan="{{ $criterion->subcriteria->count() }}" 
                                        class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-l">
                                        {{ $criterion->name }}
                                    </th>
                                @endforeach
                            </tr>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 sticky left-0 bg-gray-100 z-10"></th>
                                @foreach($criteria as $criterion)
                                    @foreach($criterion->subcriteria as $sub)
                                        <th class="px-1 py-2 text-xs text-gray-600 border-l min-w-16">{{ $sub->code }}</th>
                                    @endforeach
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($alternatives as $alternative)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900 sticky left-0 bg-white z-10 border-r min-w-48">
                                        <button onclick="showParameters({{ $alternative->id }}, '{{ $alternative->name }}')" 
                                                class="text-left hover:text-blue-600 transition-colors w-full">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                                                        <span class="text-white font-bold text-xs">{{ substr($alternative->name, 0, 2) }}</span>
                                                    </div>
                                                </div>
                                                <div class="ml-3 text-left">
                                                    <div class="text-sm font-medium truncate max-w-32">{{ $alternative->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $alternative->code }}</div>
                                                </div>
                                            </div>
                                        </button>
                                    </td>
                                    @foreach($criteria as $criterion)
                                        @foreach($criterion->subcriteria as $sub)
                                            @php
                                                $evaluation = $alternative->evaluations->where('subcriteria_id', $sub->id)->first();
                                            @endphp
                                            <td class="px-1 py-3 whitespace-nowrap text-center border-l">
                                                @if($evaluation)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        {{ $evaluation->value }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar for Parameters -->
        <div class="w-96 bg-white shadow-lg rounded-lg p-6 max-h-screen overflow-y-auto sticky top-6 transition-all duration-300" id="parameters-sidebar-container">
            <div id="parameters-sidebar">
                <div class="text-center text-gray-500 py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Parameter Nasabah</h3>
                    <p class="mt-1 text-sm text-gray-500">Klik pada nama nasabah untuk melihat parameter sebagai panduan penilaian</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let sidebarVisible = true;

function toggleSidebar() {
    const sidebar = document.getElementById('parameters-sidebar-container');
    const mainContent = document.getElementById('main-content');
    const toggleText = document.getElementById('sidebar-toggle-text');
    
    if (sidebarVisible) {
        sidebar.style.display = 'none';
        mainContent.classList.remove('flex-1');
        mainContent.classList.add('w-full');
        toggleText.textContent = 'Tampilkan Panel';
        sidebarVisible = false;
    } else {
        sidebar.style.display = 'block';
        mainContent.classList.remove('w-full');
        mainContent.classList.add('flex-1');
        toggleText.textContent = 'Sembunyikan Panel';
        sidebarVisible = true;
    }
}

function showParameters(alternativeId, alternativeName) {
    const sidebar = document.getElementById('parameters-sidebar');
    
    // Show loading state
    sidebar.innerHTML = `
        <div class="text-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
            <p class="mt-2 text-sm text-gray-500">Memuat parameter...</p>
        </div>
    `;
    
    // Fetch parameters
    fetch(`/alternatives/${alternativeId}/get-parameters`)
        .then(response => response.json())
        .then(data => {
            let html = `
                <div class="border-b border-gray-200 pb-4 mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 break-words">${alternativeName}</h3>
                    <p class="text-sm text-gray-600">Parameter untuk panduan penilaian</p>
                </div>
            `;
            
            if (Object.keys(data).length === 0) {
                html += `
                    <div class="text-center text-gray-500 py-4">
                        <p class="text-sm">Parameter belum diisi</p>
                        <a href="/alternatives/${alternativeId}/parameters" class="text-blue-600 hover:text-blue-800 text-sm underline">
                            Isi parameter
                        </a>
                    </div>
                `;
            } else {
                // Add scoring guide
                html += `
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                        <h5 class="text-xs font-semibold text-blue-900 mb-2">Panduan Scoring</h5>
                        <div class="text-xs text-blue-800 space-y-1">
                            <div class="flex justify-between"><span>Nilai 50:</span><span class="font-semibold">Skor 8-9</span></div>
                            <div class="flex justify-between"><span>Nilai 40:</span><span class="font-semibold">Skor 6-7</span></div>
                            <div class="flex justify-between"><span>Nilai 30:</span><span class="font-semibold">Skor 4-5</span></div>
                            <div class="flex justify-between"><span>Nilai 20:</span><span class="font-semibold">Skor 2-3</span></div>
                            <div class="flex justify-between"><span>Nilai 10:</span><span class="font-semibold">Skor 1</span></div>
                        </div>
                    </div>
                `;
                
                Object.keys(data).forEach(criteriaName => {
                    html += `
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-800 mb-3 text-sm border-b border-gray-100 pb-1">
                                ${criteriaName}
                            </h4>
                            <div class="space-y-3">
                    `;
                    
                    data[criteriaName].forEach(param => {
                        const scoreColor = param.nilai >= 40 ? 'text-green-600' : param.nilai >= 30 ? 'text-yellow-600' : 'text-red-600';
                        const scoreBg = param.nilai >= 40 ? 'bg-green-50 border-green-200' : param.nilai >= 30 ? 'bg-yellow-50 border-yellow-200' : 'bg-red-50 border-red-200';
                        const suggestedScore = param.nilai >= 40 ? '8-9' : param.nilai >= 30 ? '6-7' : param.nilai >= 20 ? '4-5' : param.nilai >= 10 ? '2-3' : '1';
                        
                        html += `
                            <div class="border rounded-lg p-3 ${scoreBg}">
                                <div class="text-xs font-medium text-gray-600 mb-1">${param.subcriteria.name}</div>
                                <div class="text-sm font-semibold text-gray-900 break-words mb-2">${param.parameter_name}</div>
                                <div class="flex justify-between items-center">
                                    <div class="text-xs ${scoreColor} font-medium">Nilai: ${param.nilai}</div>
                                    <div class="text-xs font-bold ${scoreColor} bg-white px-2 py-1 rounded">Skor: ${suggestedScore}</div>
                                </div>
                            </div>
                        `;
                    });
                    
                    html += `
                            </div>
                        </div>
                    `;
                });
            }
            
            sidebar.innerHTML = html;
        })
        .catch(error => {
            sidebar.innerHTML = `
                <div class="text-center text-red-500 py-8">
                    <p class="text-sm">Gagal memuat parameter</p>
                </div>
            `;
        });
}
</script>
@endsection
