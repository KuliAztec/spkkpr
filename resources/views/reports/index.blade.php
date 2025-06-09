@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <div class="h-10 w-10 rounded-lg bg-purple-500 flex items-center justify-center mr-4">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    Laporan Evaluasi
                </h1>
                <p class="mt-2 text-sm text-gray-600">Riwayat hasil evaluasi AHP yang telah disimpan</p>
            </div>
            <a href="{{ route('evaluations.results') }}" 
               class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Laporan Baru
            </a>
        </div>
    </div>

    @if($reports->count() > 0)
        <div class="grid gap-6">
            @foreach($reports as $report)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $report->title }}</h3>
                                @if($report->description)
                                    <p class="text-gray-600 mb-4">{{ $report->description }}</p>
                                @endif
                                
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                    <div class="bg-blue-50 p-3 rounded-lg">
                                        <div class="text-sm text-blue-600 font-medium">Alternatif</div>
                                        <div class="text-xl font-bold text-blue-900">{{ $report->total_alternatives }}</div>
                                    </div>
                                    <div class="bg-green-50 p-3 rounded-lg">
                                        <div class="text-sm text-green-600 font-medium">Kriteria</div>
                                        <div class="text-xl font-bold text-green-900">{{ $report->total_criteria }}</div>
                                    </div>
                                    <div class="bg-yellow-50 p-3 rounded-lg">
                                        <div class="text-sm text-yellow-600 font-medium">Sub Kriteria</div>
                                        <div class="text-xl font-bold text-yellow-900">{{ $report->total_subcriteria }}</div>
                                    </div>
                                    <div class="bg-purple-50 p-3 rounded-lg">
                                        <div class="text-sm text-purple-600 font-medium">Tanggal</div>
                                        <div class="text-sm font-bold text-purple-900">{{ $report->calculation_date->format('d/m/Y H:i') }}</div>
                                    </div>
                                </div>

                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Dibuat {{ $report->created_at->diffForHumans() }}
                                </div>
                            </div>
                            
                            <div class="flex flex-col space-y-2 ml-4">
                                <a href="{{ route('reports.show', $report) }}" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat
                                </a>
                                <a href="{{ route('reports.export', $report) }}" 
                                   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Export
                                </a>
                                <form action="{{ route('reports.destroy', $report) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm flex items-center w-full">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $reports->links() }}
        </div>
    @else
        <div class="bg-white shadow-lg rounded-lg p-8 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Laporan</h3>
            <p class="text-gray-600 mb-6">Mulai dengan melakukan evaluasi AHP dan simpan hasilnya sebagai laporan.</p>
            <a href="{{ route('evaluations.results') }}" 
               class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg">
                Buat Laporan Pertama
            </a>
        </div>
    @endif
</div>
@endsection
