@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Manajemen Sub Kriteria</h1>
        <a href="{{ route('subcriteria.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah Sub Kriteria
        </a>
    </div>

    <!-- Pairwise Comparison Buttons -->
    @php
        $criteriaWithSubs = \App\Models\Criteria::has('subcriteria', '>=', 2)->get();
    @endphp
    
    @if($criteriaWithSubs->count() > 0)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <h3 class="text-lg font-semibold text-yellow-900 mb-3">Perbandingan Berpasangan Sub Kriteria</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($criteriaWithSubs as $criteria)
                    <a href="{{ route('subcriteria.pairwise', $criteria) }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                        {{ $criteria->name }} ({{ $criteria->subcriteria->count() }} sub)
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sub Kriteria</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kriteria Utama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bobot</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($subcriteria as $sub)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-green-500 flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ $sub->code }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $sub->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $sub->description ?? 'Tidak ada deskripsi' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $sub->criteria->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $sub->weight }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('subcriteria.show', $sub) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                <a href="{{ route('subcriteria.edit', $sub) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                <form action="{{ route('subcriteria.destroy', $sub) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                Belum ada sub kriteria. <a href="{{ route('subcriteria.create') }}" class="text-blue-600 hover:text-blue-800">Tambah sub kriteria pertama</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
