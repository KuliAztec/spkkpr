<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <!-- Enhanced Navigation -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-xl border-b-4 border-blue-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo Section -->
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center text-white hover:text-blue-200 transition-colors duration-200">
                        <svg class="w-8 h-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <div>
                            <div class="text-lg font-bold whitespace-nowrap">SPK Kredit Rumah</div>
                            <div class="text-xs text-blue-200 -mt-1 whitespace-nowrap">Analytic Hierarchy Process</div>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Menu -->
                <div class="hidden lg:flex lg:items-center lg:space-x-1 flex-1 justify-center">

                    @if(Auth::user()->isSuperAdmin())
                        <a href="{{ route('criteria.index') }}" 
                           class="px-3 py-2 rounded-lg text-white hover:bg-blue-700 transition-all duration-200 flex items-center text-sm {{ request()->routeIs('criteria.*') ? 'bg-blue-700 shadow-inner' : '' }}">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Kriteria
                        </a>
                        <a href="{{ route('subcriteria.index') }}" 
                           class="px-3 py-2 rounded-lg text-white hover:bg-blue-700 transition-all duration-200 flex items-center text-sm {{ request()->routeIs('subcriteria.*') ? 'bg-blue-700 shadow-inner' : '' }}">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            Sub Kriteria
                        </a>
                        <a href="{{ route('users.index') }}" 
                           class="px-3 py-2 rounded-lg text-white hover:bg-blue-700 transition-all duration-200 flex items-center text-sm {{ request()->routeIs('users.*') ? 'bg-blue-700 shadow-inner' : '' }}">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                            Users
                        </a>
                    @endif

                    <a href="{{ route('alternatives.index') }}" 
                       class="px-3 py-2 rounded-lg text-white hover:bg-blue-700 transition-all duration-200 flex items-center text-sm {{ request()->routeIs('alternatives.*') ? 'bg-blue-700 shadow-inner' : '' }}">
                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Nasabah
                    </a>

                    <a href="{{ route('evaluations.index') }}" 
                       class="px-3 py-2 rounded-lg text-white hover:bg-blue-700 transition-all duration-200 flex items-center text-sm {{ request()->routeIs('evaluations.*') ? 'bg-blue-700 shadow-inner' : '' }}">
                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Evaluasi
                    </a>

                    <a href="{{ route('reports.index') }}" 
                       class="px-3 py-2 rounded-lg text-white hover:bg-blue-700 transition-all duration-200 flex items-center text-sm {{ request()->routeIs('reports.*') ? 'bg-blue-700 shadow-inner' : '' }}">
                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Laporan
                    </a>
                </div>

                <!-- Right Side: User Menu and Mobile Button -->
                <div class="flex items-center space-x-3">
                    <!-- User Info (Desktop) -->
                    <div class="hidden lg:flex items-center space-x-2 bg-blue-700 bg-opacity-50 rounded-lg px-3 py-1">
                        <div class="w-7 h-7 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-xs">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <div class="text-white">
                            <div class="text-xs font-medium">{{ Str::limit(Auth::user()->name, 15) }}</div>
                            <div class="text-xs text-blue-200">{{ ucfirst(Auth::user()->role) }}</div>
                        </div>
                    </div>

                    <!-- Logout Button (Desktop) -->
                    <form method="POST" action="{{ route('logout') }}" class="hidden lg:inline">
                        @csrf
                        <button type="submit" 
                                class="flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all duration-200 text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>

                    <!-- Mobile menu button -->
                    <div class="lg:hidden">
                        <button type="button" 
                                class="bg-blue-700 inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                                onclick="toggleMobileMenu()">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="lg:hidden hidden" id="mobile-menu">
            <div class="px-3 pt-2 pb-3 space-y-1 bg-blue-700 border-t border-blue-600">
                <!-- Mobile User Info -->
                <div class="flex items-center space-x-3 px-3 py-3 bg-blue-800 rounded-lg mb-3">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="text-white">
                        <div class="font-medium">{{ Auth::user()->name }}</div>
                        <div class="text-sm text-blue-200">{{ ucfirst(Auth::user()->role) }}</div>
                    </div>
                </div>

                <!-- Mobile Navigation Links -->
                <a href="{{ route('dashboard') }}" 
                   class="block px-3 py-2 rounded-md text-white hover:bg-blue-600 {{ request()->routeIs('dashboard') ? 'bg-blue-600' : '' }}">
                    Dashboard
                </a>

                @if(Auth::user()->isSuperAdmin())
                    <a href="{{ route('criteria.index') }}" 
                       class="block px-3 py-2 rounded-md text-white hover:bg-blue-600 {{ request()->routeIs('criteria.*') ? 'bg-blue-600' : '' }}">
                        Kriteria
                    </a>
                    <a href="{{ route('subcriteria.index') }}" 
                       class="block px-3 py-2 rounded-md text-white hover:bg-blue-600 {{ request()->routeIs('subcriteria.*') ? 'bg-blue-600' : '' }}">
                        Sub Kriteria
                    </a>
                    <a href="{{ route('users.index') }}" 
                       class="block px-3 py-2 rounded-md text-white hover:bg-blue-600 {{ request()->routeIs('users.*') ? 'bg-blue-600' : '' }}">
                        User Management
                    </a>
                @endif

                <a href="{{ route('alternatives.index') }}" 
                   class="block px-3 py-2 rounded-md text-white hover:bg-blue-600 {{ request()->routeIs('alternatives.*') ? 'bg-blue-600' : '' }}">
                    Nasabah
                </a>
                <a href="{{ route('evaluations.index') }}" 
                   class="block px-3 py-2 rounded-md text-white hover:bg-blue-600 {{ request()->routeIs('evaluations.*') ? 'bg-blue-600' : '' }}">
                    Evaluasi
                </a>
                <a href="{{ route('reports.index') }}" 
                   class="block px-3 py-2 rounded-md text-white hover:bg-blue-600 {{ request()->routeIs('reports.*') ? 'bg-blue-600' : '' }}">
                    Laporan
                </a>

                <!-- Mobile Logout -->
                <div class="pt-2 border-t border-blue-600 mt-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full text-left px-3 py-2 rounded-md text-white bg-red-600 hover:bg-red-700">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Enhanced Main Content -->
    <main class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <!-- Success Message -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 pt-6">
                <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-green-400 hover:text-green-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
            <div class="max-w-7xl mx-auto px-4 pt-6">
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="ml-auto pl-3">
                            <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-red-400 hover:text-red-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="py-6">
            @yield('content')
        </div>
    </main>

    <!-- Mobile Menu Toggle Script -->
    <script>
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileButton = event.target.closest('[onclick="toggleMobileMenu()"]');
            
            if (!mobileButton && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
