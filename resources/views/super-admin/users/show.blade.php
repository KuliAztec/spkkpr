@extends('layouts.superadmin')

@section('title', 'Detail User')
@section('page-title', 'Detail User: ' . $user->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('super-admin.users.index') }}" class="text-blue-600 hover:text-blue-800">
                        Kelola User
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-500">{{ $user->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Detail User</h2>
                <p class="text-gray-600 mt-1">Informasi lengkap user {{ $user->name }}</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="window.location.href='{{ route('super-admin.users.edit', $user) }}'" 
                    class="bg-green-600 hover:bg-green-700 text-black px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit User
                </button>
                @if($user->id !== auth()->id())
                <form action="{{ route('super-admin.users.destroy', $user) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center"
                            onclick="return confirm('Yakin ingin menghapus user ini?')">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-center">
                    <div class="mx-auto h-24 w-24 rounded-full bg-gray-300 flex items-center justify-center mb-4">
                        <span class="text-2xl font-bold text-gray-700">
                            {{ substr($user->name, 0, 2) }}
                        </span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    
                    <div class="mt-4">
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                            {{ $user->role === 'super_admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $user->role === 'super_admin' ? 'Super Admin' : 'Admin' }}
                        </span>
                    </div>
                    
                    <div class="mt-2">
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                            {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Detail</h4>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Nama Lengkap</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Role</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $user->role === 'super_admin' ? 'Super Admin' : 'Admin' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Status</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">No. Telepon</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $user->phone ?: '-' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Bergabung</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    
                    @if($user->address)
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Alamat</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->address }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Evaluations History (if applicable) -->
    @if($user->evaluations->count() > 0)
    <div class="mt-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Evaluasi</h4>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($user->evaluations->take(5) as $evaluation)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $evaluation->customer->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $evaluation->total_score ? number_format($evaluation->total_score, 4) : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $evaluation->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($evaluation->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($evaluation->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $evaluation->created_at->format('d M Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($user->evaluations->count() > 5)
            <div class="mt-4 text-sm text-gray-500 text-center">
                Dan {{ $user->evaluations->count() - 5 }} evaluasi lainnya...
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection