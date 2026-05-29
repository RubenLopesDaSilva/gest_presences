<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestion de Présence RFID')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2">
                    <div class="bg-blue-600 text-white p-2 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-slate-800">Présence RFID</h1>
                </div>

                <div class="hidden md:flex space-x-1">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-600 hover:bg-slate-50' }} transition-colors">
                        Tableau de bord
                    </a>
                    <a href="{{ route('scanner') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('scanner') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-600 hover:bg-slate-50' }} transition-colors">
                        Scanner
                    </a>
                    <a href="{{ route('employees') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('employees') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-600 hover:bg-slate-50' }} transition-colors">
                        Employés
                    </a>
                    <a href="{{ route('history') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('history') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-600 hover:bg-slate-50' }} transition-colors">
                        Historique
                    </a>
                </div>

                <!-- Mobile menu button -->
                <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg hover:bg-slate-50">
                    <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-200">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-600 hover:bg-slate-50' }}">
                    Tableau de bord
                </a>
                <a href="{{ route('scanner') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('scanner') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-600 hover:bg-slate-50' }}">
                    Scanner
                </a>
                <a href="{{ route('employees') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('employees') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-600 hover:bg-slate-50' }}">
                    Employés
                </a>
                <a href="{{ route('history') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('history') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-600 hover:bg-slate-50' }}">
                    Historique
                </a>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
