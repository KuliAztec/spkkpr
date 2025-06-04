<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SPK KPR') - Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Chart.js for visualizations -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Additional styles for admin features -->
    <style>
        .sidebar-scrollable {
            height: calc(100vh - 80px);
            overflow-y: auto;
        }
        
        .nav-item {
            transition: all 0.3s ease;
        }
        
        .nav-item:hover {
            transform: translateX(4px);
        }
        
        .stats-card {
            transition: transform 0.2s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="bg-indigo-800 text-white w-64 fixed h-full shadow-lg">
            <div class="p-4 border-b border-indigo-700">
                <h2 class="text-xl font-bold">SPK KPR</h2>
                <p class="text-indigo-200 text-sm">Admin Dashboard</p>
            </div>
            
            <nav class="mt-4 sidebar-scrollable">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="nav-item flex items-center px-4 py-3 hover:bg-indigo-700 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-700 border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Customer Management -->
                <div class="mt-2">
                    <p class="px-4 py-2 text-xs uppercase text-indigo-300 font-semibold">Manajemen Nasabah</p>
                    
                    <a href="{{ route('admin.customers.index') }}" class="nav-item flex items-center px-4 py-3 hover:bg-indigo-700 {{ request()->routeIs('admin.customers*') ? 'bg-indigo-700 border-r-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span>Data Nasabah</span>
                    </a>
                    
                    <a href="{{ route('admin.customers.create') }}" class="nav-item flex items-center px-4 py-3 hover:bg-indigo-700 {{ request()->routeIs('admin.customers.create') ? 'bg-indigo-700 border-r-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <span>Tambah Nasabah</span>
                    </a>
                </div>

                <!-- Evaluation & Applications -->
                <div class="mt-4">
                    <p class="px-4 py-2 text-xs uppercase text-indigo-300 font-semibold">Evaluasi & Aplikasi</p>
                    
                    <a href="{{ route('admin.applications.index') }}" class="nav-item flex items-center px-4 py-3 hover:bg-indigo-700 {{ request()->routeIs('admin.applications*') ? 'bg-indigo-700 border-r-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Aplikasi Kredit</span>
                    </a>
                    
                    <a href="{{ route('admin.evaluations.index') }}" class="nav-item flex items-center px-4 py-3 hover:bg-indigo-700 {{ request()->routeIs('admin.evaluations*') ? 'bg-indigo-700 border-r-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <span>Hasil Evaluasi</span>
                    </a>
                </div>

                <!-- Rankings & Analysis -->
                <div class="mt-4">
                    <p class="px-4 py-2 text-xs uppercase text-indigo-300 font-semibold">Analisis & Ranking</p>
                    
                    <a href="{{ route('admin.rankings.index') }}" class="nav-item flex items-center px-4 py-3 hover:bg-indigo-700 {{ request()->routeIs('admin.rankings.index') ? 'bg-indigo-700 border-r-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        <span>Ranking Nasabah</span>
                    </a>
                    
                    <a href="{{ route('admin.rankings.charts') }}" class="nav-item flex items-center px-4 py-3 hover:bg-indigo-700 {{ request()->routeIs('admin.rankings.charts') ? 'bg-indigo-700 border-r-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span>Visualisasi Data</span>
                    </a>
                    
                    <a href="{{ route('admin.rankings.comparison') }}" class="nav-item flex items-center px-4 py-3 hover:bg-indigo-700 {{ request()->routeIs('admin.rankings.comparison') ? 'bg-indigo-700 border-r-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        <span>Perbandingan</span>
                    </a>
                </div>

                <!-- Reports -->
                <div class="mt-4">
                    <p class="px-4 py-2 text-xs uppercase text-indigo-300 font-semibold">Laporan</p>
                    
                    <a href="{{ route('admin.reports.index') }}" class="nav-item flex items-center px-4 py-3 hover:bg-indigo-700 {{ request()->routeIs('admin.reports*') ? 'bg-indigo-700 border-r-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Laporan</span>
                    </a>
                </div>

                <!-- System Settings -->
                <div class="mt-4">
                    <p class="px-4 py-2 text-xs uppercase text-indigo-300 font-semibold">Sistem</p>
                    
                    <a href="{{ route('admin.criteria.index') }}" class="nav-item flex items-center px-4 py-3 hover:bg-indigo-700 {{ request()->routeIs('admin.criteria*') ? 'bg-indigo-700 border-r-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                        </svg>
                        <span>Kelola Kriteria</span>
                    </a>
                    
                    <a href="{{ route('admin.settings.index') }}" class="nav-item flex items-center px-4 py-3 hover:bg-indigo-700 {{ request()->routeIs('admin.settings*') ? 'bg-indigo-700 border-r-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Pengaturan</span>
                    </a>
                </div>
            </nav>
            
            <!-- Logout -->
            <div class="absolute bottom-4 w-full px-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-white transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 p-4 sticky top-0 z-10">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-sm text-gray-600 mt-1">@yield('page-description', 'Kelola data nasabah dan evaluasi kredit')</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Notification Bell -->
                        <div class="relative">
                            <button class="p-2 text-gray-400 hover:text-gray-600 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.07 2.82l-.03.03a3.9 3.9 0 0 0-1.3.74 4.38 4.38 0 0 0-.44.44L6.7 5.55a3.9 3.9 0 0 0-.74 1.3l-.03.03"></path>
                                </svg>
                            </button>
                            <span class="absolute top-0 right-0 block h-3 w-3 bg-red-400 rounded-full ring-2 ring-white"></span>
                        </div>
                        
                        <!-- User Info -->
                        <div class="flex items-center space-x-3">
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                            <div class="h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Breadcrumb -->
            @if(isset($breadcrumb))
            <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        @foreach($breadcrumb as $item)
                            <li class="inline-flex items-center">
                                @if(!$loop->last)
                                    <a href="{{ $item['url'] }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                                        {{ $item['title'] }}
                                    </a>
                                    <svg class="w-6 h-6 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $item['title'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </nav>
            </div>
            @endif

            <!-- Content -->
            <main class="p-6">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('warning'))
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        {{ session('warning') }}
                    </div>
                @endif

                @if(session('info'))
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('info') }}
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    @stack('scripts')
    
    <!-- Common JavaScript for admin features -->
    <script>
        // Auto-hide flash messages after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('[class*="bg-green-100"], [class*="bg-red-100"], [class*="bg-yellow-100"], [class*="bg-blue-100"]');
            alerts.forEach(function(alert) {
                if (alert.parentNode) {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                    }, 500);
                }
            });
        }, 5000);

        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>