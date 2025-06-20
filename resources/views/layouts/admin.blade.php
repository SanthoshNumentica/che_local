<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex flex-col" style="background-color: #7A2B26; color: #F5F5F5;">

    @php
        $currentRoute = request()->route()->getName();
        $activeColor = 'bg-[#5A1D1A] text-white';
        $defaultColor = 'text-black hover:bg-[#7A2B26] hover:text-white';
    @endphp

    <!-- Top Navigation Bar -->
    <nav class="bg-white shadow-md p-4 relative z-50">
        <div class="flex items-center space-x-10">
            <!-- Logo -->
            <img src="{{ asset('images/test_logo.jpg') }}" alt="Logo" class="h-10 w-auto">

            <!-- Navigation Links -->
            <ul class="flex space-x-6 items-center">
                <li>
                    <a href="{{ route('admin.home') }}"
                       class="px-3 py-2 rounded-md transition {{ $currentRoute === 'admin.home' ? $activeColor : $defaultColor }}">
                        Home
                    </a>
                </li>

                <!-- Users Dropdown -->
                <li class="relative group flex items-center">
                    <!-- Main Users link -->
                    <a href="{{ route('admin.users') }}"
                       class="px-3 py-2 rounded-md transition flex items-center gap-1 {{ Str::startsWith($currentRoute, 'admin.users') ? $activeColor : $defaultColor }}">
                        Users
                    </a>

                    <!-- Arrow for dropdown -->
                    <button class="px-1 py-2 transition" aria-haspopup="true">
                        <svg class="w-4 h-4 text-black group-hover:rotate-180 transition-transform" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <ul class="absolute left-0 top-full hidden group-hover:block bg-white text-black mt-1 rounded-md shadow-md z-50 min-w-[160px]">
                        <li>
                            <a href="{{ route('admin.users') }}"
                               class="block px-4 py-2 hover:bg-gray-100 {{ $currentRoute === 'admin.users' ? 'font-semibold bg-gray-100' : '' }}">
                                Users
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.requests') }}"
                               class="block px-4 py-2 hover:bg-gray-100 {{ $currentRoute === 'admin.userRequests' ? 'font-semibold bg-gray-100' : '' }}">
                                User Requests
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('admin.master') }}"
                       class="px-3 py-2 rounded-md transition {{ $currentRoute === 'admin.master' ? $activeColor : $defaultColor }}">
                        Master Data
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.map') }}"
                       class="px-3 py-2 rounded-md transition {{ $currentRoute === 'admin.map' ? $activeColor : $defaultColor }}">
                        Map Maker
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.report') }}"
                       class="px-3 py-2 rounded-md transition {{ $currentRoute === 'admin.report' ? $activeColor : $defaultColor }}">
                        Report
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-1 p-6">
        @yield('content')
    </main>

</body>

</html>
