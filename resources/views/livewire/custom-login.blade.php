<form
    wire:submit.prevent="login"
    x-data="{ loading: false, error: @entangle('error') }"
    @submit="loading = true"
    x-init="$watch('error', value => { if (value) loading = false })"
    class="space-y-4 w-full max-w-xl">

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
    <div x-data="{ show: false }">
        <label class="block text-white mb-1">Password</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 11c1.105 0 2-.895 2-2V7a2 2 0 10-4 0v2c0 1.105.895 2 2 2zm6 0v7a2 2 0 01-2 2H8a2 2 0 01-2-2v-7h12z" />
                </svg>
            </span>
            <input
                :type="show ? 'text' : 'password'"
                wire:model="password"
                placeholder="Password"
                class="w-full pl-10 pr-10 p-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white bg-opacity-20 text-white placeholder-gray-300">
            <!-- Toggle icon -->
            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-300">
                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.985 9.985 0 013.617-4.568m3.999-1.37A10.035 10.035 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.976 9.976 0 01-1.357 2.572M15 12a3 3 0 00-3-3m0 0a3 3 0 00-2.995 2.824M3 3l18 18" />
                </svg>
            </button>
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

    <button
        type="submit"
        class="w-full text-white py-2 px-4 rounded flex items-center justify-center transition-opacity duration-300"
        style="background: linear-gradient(to right, #F9B902, #E09100);"
        :class="{ 'opacity-50 blur-sm cursor-not-allowed': loading }"
        :disabled="loading">
        <template x-if="loading">
            <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
            </svg>
        </template>
        <span x-text="loading ? 'Logging in...' : 'Login'"></span>
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
