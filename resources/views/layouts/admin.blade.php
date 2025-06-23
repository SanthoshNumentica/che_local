<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="flex text-black" style="background: radial-gradient(circle at center,  #000000, #7A2B26);">

    @php
    $currentRoute = request()->route()->getName();
    $activeColor = 'text-[#7A2B26] font-medium';
    $defaultColor = 'text-black text-black hover:text-[#5A1D1A] font-medium';
    @endphp

    <!-- Sidebar -->
    <aside class="w-64 bg-white rounded-md flex flex-col m-2 p-4">
        <!-- Logo -->
        <div class="flex items-center mb-8">
            <img src="{{ asset('images/test_logo.jpg') }}" alt="Logo" class="h-10 w-auto mx-auto">
        </div>

        <!-- Navigation -->
        <nav class="flex flex-col space-y-2">
            <!-- Home -->
            <a href="{{ route('admin.home') }}"
                class="flex items-center gap-2 px-4 py-2 transition {{ $currentRoute === 'admin.home' ? $activeColor : $defaultColor }}">
                <img src="{{ asset('images/header/home-icon.png') }}" alt="Home" class="w-5 h-5">
                Home
            </a>

            <!-- Users Dropdown -->
            @php
            $userRoutesActive = Str::startsWith($currentRoute, 'admin.users') || Str::startsWith($currentRoute, 'admin.userRequests');
            @endphp

            <div class="relative">
                <button onclick="toggleDropdown('userDropdown', 'dropdownIcon')"
                    class="w-full flex items-center justify-between px-4 py-2 hover:text-[#5A1D1A] font-medium">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/header/users-icon.png') }}" alt="Users" class="w-5 h-5">
                        <span>Users</span>
                    </div>
                    <svg id="dropdownIcon"
                        class="w-4 h-4 transform transition-transform duration-300 {{ $userRoutesActive ? 'rotate-180' : '' }}"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div id="userDropdown"
                    class="ml-8 mt-1 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ $userRoutesActive ? '' : 'hidden' }}"
                    style="{{ $userRoutesActive ? 'max-height: 100px; opacity: 1;' : 'max-height: 0; opacity: 0;' }}">
                    <a href="{{ route('admin.users') }}"
                        class="block px-4 py-2 transition {{ $currentRoute === 'admin.users' ? $activeColor : $defaultColor }}">
                        All Users
                    </a>
                    <a href="{{ route('admin.users.requests') }}"
                        class="block px-4 py-2 transition {{ $currentRoute === 'admin.users.requests' ? $activeColor : $defaultColor }}">
                        User Requests
                    </a>
                </div>
            </div>

            <!-- Master Data -->
            <a href="{{ route('admin.master') }}"
                class="flex items-center gap-2 px-4 py-2 transition {{ $currentRoute === 'admin.master' ? $activeColor : $defaultColor }}">
                <img src="{{ asset('images/header/master_data-icon.png') }}" alt="Master Data" class="w-5 h-5">
                Master Data
            </a>

            <!-- Map Maker -->
            <a href="{{ route('admin.map') }}"
                class="flex items-center gap-2 px-4 py-2 transition {{ $currentRoute === 'admin.map' ? $activeColor : $defaultColor }}">
                <img src="{{ asset('images/header/map-maker-icon.png') }}" alt="Map Maker" class="w-5 h-5">
                Map Maker
            </a>

            <!-- Report -->
            <a href="{{ route('admin.report') }}"
                class="flex items-center gap-2 px-4 py-2 transition {{ $currentRoute === 'admin.report' ? $activeColor : $defaultColor }}">
                <img src="{{ asset('images/header/report-icon.png') }}" alt="Report" class="w-5 h-5">
                Report
            </a>
        </nav>


        <!-- Footer Info -->
        <div class="mt-auto text-xs text-center bg-gray-100 text-gray-700 rounded-md px-3 py-4 shadow-inner">
            <p class="font-semibold text-sm text-[#5A1D1A]">ITOI Technologies</p>
            <p class="text-[11px]">© 2025 All Rights Reserved</p>
            <p class="text-[11px]">Version - <span class="font-medium">v10.39092</span></p>
        </div>

    </aside>

    <main class="flex-1 p-4 bg-white rounded-md m-2 ml-0">

        <!-- Header Bar -->
        <div class="flex items-center justify-between mb-6 border-b border-gray-200 pb-4">

            <!-- Back Button -->
            <button onclick="history.back()" class="flex items-center space-x-2 text-[#7A2B26] hover:text-[#5A1D1A] font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Back</span>
            </button>

            <!-- Search Bar (Centered) -->
            <div class="flex-1 px-4">
                <div class="max-w-md mx-auto relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M16 10a6 6 0 11-12 0 6 6 0 0112 0z" />
                        </svg>
                    </span>
                    <input type="text" placeholder="Search Users, Reports, Data..." class="w-full text-[14px] border border-gray-300 rounded-md px-10 py-2 focus:outline-none focus:ring-1 focus:ring-[#7A2B26]" />
                </div>
            </div>

            <!-- Container for Profile and Dropdown -->
            <div class="relative group">
                <!-- Profile Icon -->
                <img src="{{ asset('images/profile.png') }}" alt="Profile" class="w-10 h-10 rounded-full cursor-pointer">

                <!-- Dropdown Menu -->
                <div class="absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible group-hover:translate-y-1 transform transition-all duration-200 z-50">
                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <!-- User Icon -->
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v1h16v-1c0-2.66-5.33-4-8-4z" />
                        </svg>
                        Admin
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <!-- Logout Icon -->
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>


        </div>

        <!-- Page Content -->
        <div class="overflow-y-auto pr-2">
            @yield('content')
        </div>

    </main>


</body>

</html>

<script>
    function toggleDropdown(contentId, iconId) {
        const content = document.getElementById(contentId);
        const icon = document.getElementById(iconId);

        // Icon rotation
        icon.classList.toggle('rotate-180');

        // Smooth dropdown animation using maxHeight
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            content.style.maxHeight = content.scrollHeight + "px";
            content.style.opacity = "1";
            content.style.transition = "max-height 0.3s ease, opacity 0.3s ease";
        } else {
            content.style.maxHeight = "0";
            content.style.opacity = "0";
            content.addEventListener('transitionend', () => {
                content.classList.add('hidden');
            }, {
                once: true
            });
        }
    }
</script>
<style>
    html, body {
        height: 100%;
    }
</style>
