<form wire:submit.prevent="login" class="space-y-4 w-full max-w-xl">
    <h2 class="text-2xl font-semibold text-center text-white">Welcome Back!</h2>

    {{-- Email Field --}}
    <div>
        <label class="block text-white mb-1">Email ID</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4h16v16H4V4zm0 0l8 8 8-8" />
                </svg>
            </span>
            <input type="text" wire:model="userName" placeholder="Username"
                   class="w-full pl-10 p-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white bg-opacity-20 text-white placeholder-gray-300">
        </div>
    </div>

    {{-- Password Field --}}
    <div>
        <label class="block text-white mb-1">Password</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 11c1.105 0 2-.895 2-2V7a2 2 0 10-4 0v2c0 1.105.895 2 2 2zm6 0v7a2 2 0 01-2 2H8a2 2 0 01-2-2v-7h12z"/>
                </svg>
            </span>
            <input type="password" wire:model="password" placeholder="Password"
                   class="w-full pl-10 p-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white bg-opacity-20 text-white placeholder-gray-300">
        </div>
    </div>

    {{-- Error Message --}}
    @if ($error)
        <p class="text-red-500">{{ $error }}</p>
    @endif

    {{-- API Result (optional for debugging) --}}
    @if ($apiResult)
        <div class="bg-black bg-opacity-50 text-white text-xs p-2 rounded">
            <strong>API Response:</strong>
            <pre>{{ json_encode($apiResult, JSON_PRETTY_PRINT) }}</pre>
        </div>
    @endif

    {{-- Login Button --}}
    <button type="submit"
            class="w-full text-white py-2 px-4 rounded"
            style="background: linear-gradient(to right, #F9B902, #E09100);">
        Login
    </button>

    {{-- Footer --}}
    <div class="pt-6 flex justify-between text-xs text-gray-200">
        <div>
            <span class="block">ITOI Technologies</span>
            <span class="block">©2025 All Rights Reserved</span>
        </div>
        <div class="self-end text-right">
            <span>Version - v10.39092</span>
        </div>
    </div>
</form>
