@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Hasil Perhitungan AHP</h1>
        <div class="flex space-x-3">
            <a href="{{ route('evaluations.calculate') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                Hitung Ulang
            </a>
            <a href="{{ route('evaluations.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </div>

    <!-- Top 5 Results -->
    <div class="bg-white shadow sm:rounded-lg mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Top 5 Nasabah Terbaik</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @foreach($alternatives->take(5) as $index => $alternative)
                    <div class="bg-gradient-to-r {{ $index == 0 ? 'from-yellow-400 to-yellow-600' : ($index == 1 ? 'from-gray-300 to-gray-500' : ($index == 2 ? 'from-yellow-600 to-yellow-800' : 'from-blue-400 to-blue-600')) }} text-white p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold">#{{ $alternative->rank }}</div>
                        <div class="font-medium">{{ $alternative->name }}</div>
                        <div class="text-sm opacity-90">{{ $alternative->code }}</div>
                        <div class="text-lg font-semibold mt-2">{{ number_format($alternative->final_score, 4) }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Detailed Results -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Hasil Lengkap</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nasabah</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Skor Final</th>
                        @foreach($criteria as $criterion)
                            <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-l">
                                {{ $criterion->name }}
                                <div class="text-xs font-normal">({{ number_format($criterion->weight, 3) }})</div>
                            </th>
                        @endforeach
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($alternatives as $alternative)
                        <tr class="hover:bg-gray-50 {{ $alternative->rank <= 3 ? 'bg-green-50' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $alternative->rank == 1 ? 'bg-yellow-100 text-yellow-800' : ($alternative->rank <= 3 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                    #{{ $alternative->rank }}
                                </span>
                            </td>
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
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-lg font-semibold text-blue-600">
                                    {{ number_format($alternative->final_score, 4) }}
                                </span>
                            </td>
                            @foreach($criteria as $criterion)
                                @php
                                    $criteriaScore = 0;
                                    $totalSubWeight = $criterion->subcriteria->sum('weight');
                                    
                                    foreach($criterion->subcriteria as $sub) {
                                        $evaluation = $alternative->evaluations->where('subcriteria_id', $sub->id)->first();
                                        if($evaluation && $totalSubWeight > 0) {
                                            $subWeight = $sub->weight / $totalSubWeight;
                                            $criteriaScore += $evaluation->normalized_value * $subWeight;
                                        }
                                    }
                                @endphp
                                <td class="px-3 py-4 whitespace-nowrap text-center border-l">
                                    <span class="text-sm font-medium">{{ number_format($criteriaScore, 3) }}</span>
                                </td>
                            @endforeach
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="{{ route('alternatives.show', $alternative) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Criteria Weights Summary -->
    <div class="mt-8 bg-white shadow sm:rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Bobot Kriteria</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @foreach($criteria as $criterion)
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <div class="font-medium text-gray-900">{{ $criterion->name }}</div>
                        <div class="text-sm text-gray-600">{{ $criterion->code }}</div>
                        <div class="text-lg font-semibold text-blue-600 mt-2">{{ number_format($criterion->weight, 4) }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ $criterion->subcriteria->count() }} sub kriteria</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Save Report Button (add this to the action buttons area) -->
    <div class="mt-6 flex justify-center">
        <button onclick="openSaveModal()" 
                class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            Simpan sebagai Laporan
        </button>
    </div>
</div>

<!-- Save Report Modal (moved outside and always rendered) -->
<div id="saveReportModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Simpan Laporan Evaluasi</h3>
            <form action="{{ route('reports.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Laporan</label>
                    <input type="text" name="title" id="title" required
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500"
                           placeholder="Evaluasi Kredit - {{ date('F Y') }}"
                           value="Evaluasi Kredit - {{ date('F Y') }}">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500"
                              placeholder="Deskripsi singkat tentang evaluasi ini..."></textarea>
                </div>
                <div class="flex space-x-3">
                    <button type="button" onclick="closeModal()"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                        Simpan Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openSaveModal() {
    const modal = document.getElementById('saveReportModal');
    if (modal) {
        modal.classList.remove('hidden');
    }
}

function closeModal() {
    const modal = document.getElementById('saveReportModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('saveReportModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
    }
    
    // Auto show modal if triggered from calculation
    @if(session('show_save_report'))
        openSaveModal();
    @endif
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});
</script>

@endsection
