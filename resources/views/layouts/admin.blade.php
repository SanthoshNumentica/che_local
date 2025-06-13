<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen" style="background-color: #7A2B26; color: #F5F5F5;">

    @php
        $currentRoute = request()->route()->getName();
        $activeColor = 'bg-[#5A1D1A] text-white'; // Mix of #7A2B26 and black
        $defaultColor = 'text-black hover:bg-[#7A2B26] hover:text-white';
    @endphp

    <!-- Sidebar -->
    <div class="w-64 bg-white p-4 space-y-4 shadow-md">
    <ul class="space-y-2">
        <li>
            <a href="{{ route('admin.home') }}"
               class="block px-3 py-2 rounded-md transition 
               {{ $currentRoute === 'admin.home' ? $activeColor : $defaultColor }}">
                Home
            </a>
        </li>
        <hr class="border-t border-gray-200">
        
        <li>
            <a href="{{ route('admin.users') }}"
               class="block px-3 py-2 rounded-md transition 
               {{ $currentRoute === 'admin.users' ? $activeColor : $defaultColor }}">
                Users
            </a>
        </li>
        <hr class="border-t border-gray-200">
        
        <li>
            <a href="{{ route('admin.master') }}"
               class="block px-3 py-2 rounded-md transition 
               {{ $currentRoute === 'admin.master' ? $activeColor : $defaultColor }}">
                Master Data
            </a>
        </li>
        <hr class="border-t border-gray-200">
        
        <li>
            <a href="{{ route('admin.map') }}"
               class="block px-3 py-2 rounded-md transition 
               {{ $currentRoute === 'admin.map' ? $activeColor : $defaultColor }}">
                Map Maker
            </a>
        </li>
        <hr class="border-t border-gray-200">
        
        <li>
            <a href="{{ route('admin.report') }}"
               class="block px-3 py-2 rounded-md transition 
               {{ $currentRoute === 'admin.report' ? $activeColor : $defaultColor }}">
                Report
            </a>
        </li>
        <hr class="border-t border-gray-200">
    </ul>
</div>


    <!-- Main Content -->
    <div class="flex-1 p-6">
        @yield('content')
    </div>

</body>
</html>
