<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SPK KPR') - Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="bg-blue-800 text-white w-64 fixed h-full">
            <div class="p-4">
                <h2 class="text-xl font-bold">SPK KPR</h2>
                <p class="text-blue-200 text-sm">Super Admin</p>
            </div>
            
            <nav class="mt-8">
                <a href="{{ route('super-admin.dashboard') }}" class="flex items-center px-4 py-3 hover:bg-blue-700 {{ request()->routeIs('super-admin.dashboard') ? 'bg-blue-700' : '' }}">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('super-admin.criteria.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-700 {{ request()->routeIs('super-admin.criteria*') ? 'bg-blue-700' : '' }}">
                    <span>Kelola Kriteria</span>
                </a>
                <a href="{{ route('super-admin.ahp-weights.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-700 {{ request()->routeIs('super-admin.ahp-weights*') ? 'bg-blue-700' : '' }}">
                    <span>Bobot AHP</span>
                </a>
                <a href="{{ route('super-admin.users.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-700 {{ request()->routeIs('super-admin.users*') ? 'bg-blue-700' : '' }}">
                    <span>Kelola User</span>
                </a>
                <a href="{{ route('super-admin.reports.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-700 {{ request()->routeIs('super-admin.reports*') ? 'bg-blue-700' : '' }}">
                    <span>Laporan Evaluasi</span>
                </a>
            </nav>
            
            <!-- Logout -->
            <div class="absolute bottom-4 w-full px-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-white">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 p-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>