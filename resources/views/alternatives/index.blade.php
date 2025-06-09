@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Manajemen Nasabah</h1>
        <a href="{{ route('alternatives.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah Nasabah
        </a>
    </div>

    <div class="flex gap-6">
        <!-- Main Content -->
        <div class="flex-1">
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nasabah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skor AHP</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ranking</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($alternatives as $alternative)
                                <tr class="hover:bg-gray-50 cursor-pointer" onclick="showParameters({{ $alternative->id }}, '{{ $alternative->name }}')">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
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
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-semibold text-blue-600">
                                            {{ $alternative->final_score > 0 ? number_format($alternative->final_score, 4) : 'Belum dihitung' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($alternative->rank > 0)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $alternative->rank <= 3 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                #{{ $alternative->rank }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2" onclick="event.stopPropagation()">
                                        <a href="{{ route('alternatives.show', $alternative) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                        <a href="{{ route('alternatives.edit', $alternative) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                        <a href="{{ route('alternatives.parameters', $alternative) }}" class="text-green-600 hover:text-green-900">Parameter</a>
                                        <form action="{{ route('alternatives.destroy', $alternative) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada data nasabah. <a href="{{ route('alternatives.create') }}" class="text-blue-600 hover:text-blue-800">Tambah nasabah pertama</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar for Parameters -->
        <div class="w-80 bg-white shadow-lg rounded-lg p-6 max-h-screen overflow-y-auto sticky top-6">
            <div id="parameters-sidebar">
                <div class="text-center text-gray-500 py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Parameter Nasabah</h3>
                    <p class="mt-1 text-sm text-gray-500">Klik pada nasabah untuk melihat parameter</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
                    <h3 class="text-lg font-semibold text-gray-900">${alternativeName}</h3>
                    <p class="text-sm text-gray-600">Parameter yang dipilih</p>
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
                        html += `
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="text-xs font-medium text-gray-600">${param.subcriteria.name}</div>
                                <div class="text-sm font-semibold text-gray-900">${param.parameter_name}</div>
                                <div class="text-xs ${scoreColor} font-medium">Nilai: ${param.nilai}</div>
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
