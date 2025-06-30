<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('css/tailwind/tailwind.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="flex text-black h-screen" style="background: radial-gradient(circle at center,  #000000, #7A2B26);">

    @php
    $currentRoute = request()->route()->getName();
    $activeColor = 'text-[#7A2B26] font-medium';
    $defaultColor = 'text-black hover:text-[#5A1D1A] font-medium';
    @endphp

    <!-- Sidebar -->
    <aside class="w-[20%] bg-white rounded-md flex flex-col m-2 p-4">
        <!-- Logo -->
        <div class="flex items-center mb-8">
            <img src="{{ asset('images/test_logo.jpg') }}" alt="Logo" class="h-10 w-auto mx-auto">
        </div>

        <nav class="flex flex-col space-y-2">
            <a href="{{ route('admin.home') }}"
                class="flex items-center gap-2 px-4 py-2 transition {{ $currentRoute === 'admin.home' ? $activeColor : $defaultColor }}">
                <img src="{{ asset('images/header/home-icon.png') }}" class="w-5 h-5"> Home
            </a>

            @php
            $userRoutesActive = Str::startsWith($currentRoute, 'admin.users') || Str::startsWith($currentRoute, 'admin.userRequests');
            @endphp
            <div class="relative">
                <button onclick="toggleDropdown('userDropdown', 'dropdownIcon')"
                    class="w-full flex items-center justify-between px-4 py-2 hover:text-[#5A1D1A] font-medium">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/header/users-icon.png') }}" class="w-5 h-5"> <span>Users</span>
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

            <a href="{{ route('admin.master-data') }}"
                class="flex items-center gap-2 px-4 py-2 transition {{ $currentRoute === 'admin.master-data' ? $activeColor : $defaultColor }}">
                <img src="{{ asset('images/header/master_data-icon.png') }}" class="w-5 h-5"> Master Data
            </a>


            <a href="{{ route('admin.map') }}"
                class="flex items-center gap-2 px-4 py-2 transition {{ $currentRoute === 'admin.map' ? $activeColor : $defaultColor }}">
                <img src="{{ asset('images/header/map-maker-icon.png') }}" class="w-5 h-5"> Map Maker
            </a>

            <a href="{{ route('admin.report') }}"
                class="flex items-center gap-2 px-4 py-2 transition {{ $currentRoute === 'admin.report' ? $activeColor : $defaultColor }}">
                <img src="{{ asset('images/header/report-icon.png') }}" class="w-5 h-5"> Report
            </a>
        </nav>

        <div class="mt-auto text-xs text-center bg-gray-100 text-gray-700 rounded-md px-3 py-4 shadow-inner">
            <p class="font-semibold text-sm text-[#5A1D1A]">ITOI Technologies</p>
            <p class="text-[11px]">© 2025 All Rights Reserved</p>
            <p class="text-[11px]">Version - <span class="font-medium">v10.39092</span></p>
        </div>
    </aside>

    <main class="w-[80%] flex flex-col p-4 bg-white rounded-md m-2 ml-0">

        <!-- Header Bar -->
        <div class="flex items-center justify-between mb-6 border-b border-gray-200 pb-4">
            @if ($currentRoute !== 'admin.home')
            <button onclick="history.back()" class="flex items-center space-x-2 text-[#7A2B26] hover:text-[#5A1D1A] font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Back</span>
            </button>
            @endif

            <div class="flex-1 px-4">
                <div class="max-w-md mx-auto relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35M16 10a6 6 0 11-12 0 6 6 0 0112 0z" />
                        </svg>
                    </span>
                    <input type="text" placeholder="Search Users, Reports, Data..."
                        class="w-full text-[14px] border border-gray-300 rounded-md px-10 py-2 focus:outline-none focus:ring-1 focus:ring-[#7A2B26]" />
                </div>
            </div>

            <div class="relative group">
                <img src="{{ asset('images/profile.png') }}" alt="Profile"
                    class="w-10 h-10 rounded-full cursor-pointer">
                <div
                    class="absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible group-hover:translate-y-1 transform transition-all duration-200 z-50">
                    <a href="#" id="viewProfile"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v1h16v-1c0-2.66-5.33-4-8-4z" />
                        </svg>
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="overflow-y-auto pr-2 flex-1 custom-scrollbar">
            @yield('content')
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script type="text/javascript">
        @if(session('success'))
        toastr.success(@json(session('success')));
        @endif

        @if(session('error'))
        toastr.error(@json(session('error')));
        @endif
    </script>

            <div class="grid grid-cols-2 gap-6 text-sm mb-6">
                <div>
                    <p class="text-gray-600 font-medium">First Name</p>
                    <p id="modalFirstName" class="font-semibold text-gray-900">-</p>
                </div>
                <div>
                    <p class="text-gray-600 font-medium">Last Name</p>
                    <p id="modalLastName" class="font-semibold text-gray-900">-</p>
                </div>
                <div>
                    <p class="text-gray-600 font-medium">Email</p>
                    <p id="modalEmail" class="font-semibold text-gray-900 break-all">-</p>
                </div>
                <div>
                    <p class="text-gray-600 font-medium">Mobile</p>
                    <p id="modalMobile" class="font-semibold text-gray-900">-</p>
                </div>
                <div>
                    <p class="text-gray-600 font-medium">Status</p>
                    <p id="modalStatus" class="font-semibold text-gray-900">-</p>
                </div>
                <div>
                    <p class="text-gray-600 font-medium">Last Login</p>
                    <p id="modalLastLogin" class="font-semibold text-gray-900">-</p>
                </div>
                <div class="col-span-2">
                    <p class="text-gray-600 font-medium">Created At</p>
                    <p id="modalCreatedAt" class="font-semibold text-gray-900">-</p>
                </div>
            </div>
        </div>
    </div>
</body>


</html>
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out forwards;
    }
</style>

<script>
    const apiToken = "{{ Cache::get('api_token') }}";

    async function fetchUserProfile() {
        try {
            const response = await fetch("https://che.inheritinitiative.org/api/v1/auth/userList?page=1&limit=10", {
                headers: {
                    'Authorization': `Bearer ${apiToken}`,
                    'Accept': 'application/json',
                }
            });

            const data = await response.json();
            const user = data?.result?.data?.[0];

            if (!user) {
                alert("No user found.");
                return;
            }

            // Inject into modal
            document.getElementById("modalFirstName").textContent = user.firstName || '-';
            document.getElementById("modalLastName").textContent = user.lastName || '-';
            document.getElementById("modalEmail").textContent = user.userName || '-';
            document.getElementById("modalMobile").textContent = user.mobileNo || '-';
            document.getElementById("modalLastLogin").textContent = user.lastLoginDate ?
                new Date(user.lastLoginDate).toLocaleString() :
                'Never';
            const statusEl = document.getElementById("modalStatus");
            statusEl.textContent = user.status || '-';

            // Add color based on status
            if (user.status === "ACTIVE") {
                statusEl.classList.add("text-green-600");
                statusEl.classList.remove("text-gray-900");
            } else {
                statusEl.classList.add("text-gray-600");
                statusEl.classList.remove("text-green-600");
            }
            document.getElementById("modalCreatedAt").textContent = new Date(user.createdAt).toLocaleString();

            // Show modal
            document.getElementById("userModal").classList.remove("hidden");
        } catch (error) {
            console.error("API Error:", error);
            alert("Failed to load user profile.");
        }
    }

    function closeModal() {
        document.getElementById("userModal").classList.add("hidden");
    }

    // Bind click on profile image
    document.addEventListener("DOMContentLoaded", () => {
        const profileIcon = document.querySelector('img[alt="Profile"]');
        if (profileIcon) {
            profileIcon.addEventListener("click", fetchUserProfile);
        }
    });
</script>


<script>
    function toggleDropdown(contentId, iconId) {
        const content = document.getElementById(contentId);
        const icon = document.getElementById(iconId);
        icon.classList.toggle('rotate-180');
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            content.style.maxHeight = content.scrollHeight + "px";
            content.style.opacity = "1";
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


    document.getElementById('viewProfile').addEventListener('click', function(e) {
        e.preventDefault();
        fetchUserProfile();
    });
</script>

<style>
    html,
    body {
        height: 100%;
    }

    .custom-scrollbar::-webkit-scrollbar-button {
        display: none;
        /* Removes top & bottom arrows */
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background-color: #5A1D1A;
    }

    /* Firefox */
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #6D4C41  #ffffff;
    }

    /* Custom Toastr Success */
    .toast-success {
        background-color: #2E7D32 !important;
        color: #fff !important;
        font-weight: medium;
        border-left: 6px solid #1B5E20 !important;
    }

    /* Custom Toastr Error */
    .toast-error {
        background-color: #BF360C !important;
        color: #fff !important;
        font-weight: medium;
        border-left: 6px solid #A42F0A !important;
    }


    /* Common toast styling */
    #toast-container>div {
        border-radius: 8px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
    }
</style>