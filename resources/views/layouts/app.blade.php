<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sanra Hotel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="bg-gray-100 font-sans">
<div id="alertContainer" class="fixed top-5 right-5 z-50 space-y-2"></div>

<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 h-full w-64 bg-orange-600 text-white flex flex-col z-40 overflow-y-auto">
        <!-- Logo / Title -->
        <div class="p-6 text-2xl font-bold border-b border-orange-500">
            PSU San Rafael
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-2 space-y-2">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-2 py-2 px-3 rounded transition-colors
                       {{ request()->routeIs('dashboard') ? 'bg-orange-500 text-white' : 'hover:bg-orange-500' }}">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('rooms.index') }}"
                       class="flex items-center gap-2 py-2 px-3 rounded transition-colors
                       {{ request()->routeIs('rooms.*') ? 'bg-orange-500 text-white' : 'hover:bg-orange-500' }}">
                        <i data-lucide="bed" class="w-5 h-5"></i>
                        <span>Rooms</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('reservation.index') }}"
                       class="flex items-center gap-2 py-2 px-3 rounded transition-colors
                       {{ request()->routeIs('reservation.index') ? 'bg-orange-500 text-white' : 'hover:bg-orange-500' }}">
                        <i data-lucide="calendar-check" class="w-5 h-5"></i>
                        <span>Reservations</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('checkins.index') }}"
                       class="flex items-center gap-2 py-2 px-3 rounded transition-colors
                       {{ request()->routeIs('checkins.index') ? 'bg-orange-500 text-white' : 'hover:bg-orange-500' }}">
                        <i data-lucide="log-in" class="w-5 h-5"></i>
                        <span>Check Ins</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('guests.index') }}"
                       class="flex items-center gap-2 py-2 px-3 rounded transition-colors
                       {{ request()->routeIs('guests.*') ? 'bg-orange-500 text-white' : 'hover:bg-orange-500' }}">
                        <i data-lucide="users" class="w-5 h-5"></i>
                        <span>Guests</span>
                    </a>
                </li>

                 <li>
                    <a href="{{route('billings.index')}}"
                       class="flex items-center gap-2 py-2 px-3 rounded transition-colors
                       {{ request()->routeIs('billings.index') ? 'bg-orange-500 text-white' : 'hover:bg-orange-500' }}">
                        <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                        <span>Billing</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('reservation.index') }}"
                       class="flex items-center gap-2 py-2 px-3 rounded transition-colors
                       {{ request()->routeIs('reservation.index') ? 'bg-orange-500 text-white' : 'hover:bg-orange-500' }}">
                        <i data-lucide="shield" class="w-5 h-5"></i>
                        <span>Admin</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Logout -->
        <div class="p-4 border-t border-orange-500">
            <a href="#" class="block py-2 px-3 rounded hover:bg-orange-500 transition-colors">
                Logout
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 ml-64 flex flex-col">
        <!-- Navbar -->
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-orange-600">
                @yield('page-title', 'Hospitality Management Hostel PMS')
            </h1>

            <div class="flex items-center space-x-4">
                <span class="text-gray-700">Admin</span>
                <img src="https://i.pravatar.cc/40" alt="Profile" class="w-10 h-10 rounded-full border-2 border-orange-500">
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>
    </div>
</div>
<el-dialog>
    @yield('add-modal')
</el-dialog>

@stack('scripts')

<script>
window.alertData = {
    @if(session('success'))
        success: "{{ session('success') }}",
    @endif
    @if(session('error'))
        error: "{{ session('error') }}",
    @endif
    @if(session('info'))
        info: "{{ session('info') }}",
    @endif
};
</script>

<script src="{{ asset('assets/js/alert.js') }}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/lucide.js') }}?v={{ time() }}"></script>
<script>
    lucide.createIcons();
</script>

</body>
</html>
