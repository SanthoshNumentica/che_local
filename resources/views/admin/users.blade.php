@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<script src="//unpkg.com/alpinejs" defer></script>

<div class="flex items-center justify-between mb-4">
    <h1 class="text-[25px] font-medium">{{ $title }}</h1>
    <div onclick="location.reload()"
        class="w-32 text-center text-sm rounded font-medium text-[#5e1f1b] p-2 bg-white border border-[#7A2B26] flex items-center justify-center gap-1 cursor-pointer hover:bg-[#f3eae9] hover:border-[#5e1f1b] transition-colors duration-200">
        <img src="{{ asset('images/icons/refresh-icon.png') }}" class="w-4 h-4" alt="Refresh Icon">
        Refresh Data
    </div>
</div>

@if (count($data) > 0)

    <div class="mb-2 text-sm text-gray-700">
        Showing page {{ $meta['currentPage'] ?? 1 }} of {{ $meta['pageCount'] ?? 1 }} — displaying {{ count($data) }} records
    </div>

    <div class="w-full overflow-x-auto rounded-xl shadow bg-white">
        <table class="w-full divide-y divide-gray-200 text-sm text-gray-800">
            <thead>
                <tr class="bg-gradient-to-r from-[#BF360C] to-[#6D4C41] text-white uppercase text-xs text-left">
                    <th class="px-5 py-3 rounded-tl-xl">S/No</th>
                    <th class="px-5 py-3">Category Name</th>
                    <th class="px-5 py-3">Created By</th>
                    <th class="px-5 py-3">Created At</th>
                    <th class="px-5 py-3">Updated At</th>
                    <th class="px-5 py-3 rounded-tr-xl text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $category)
                    @php
                        $fullName = $category['createdByUser']['fullName']
                            ?? trim(($category['createdByUser']['firstName'] ?? '') . ' ' . ($category['createdByUser']['lastName'] ?? '')) ?: '-';
                    @endphp

                    <tr x-data="{ open: false, category: {{ json_encode($category) }} }"
                        class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition duration-200">
                        <td class="px-5 py-4">{{ $index + 1 }}</td>
                        <td class="px-5 py-4" x-text="category.categoryName ?? '-'"></td>
                        <td class="px-5 py-4">{{ $fullName }}</td>
                        <td class="px-5 py-4">
                            {{ isset($category['createdAt']) ? \Carbon\Carbon::parse($category['createdAt'])->format('d M Y h:i A') : '-' }}
                        </td>
                        <td class="px-5 py-4">
                            {{ isset($category['updatedAt']) ? \Carbon\Carbon::parse($category['updatedAt'])->format('d M Y h:i A') : '-' }}
                        </td>
                        <td class="px-5 py-4 flex justify-center items-center space-x-3">
                            <!-- View -->
                            <div class="relative group inline-block">
                                <button @click="open = true"
                                    class="bg-green-600 hover:bg-green-700 text-white p-2 rounded transition duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <div
                                    class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 bg-black text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition duration-200 pointer-events-none">
                                    View
                                </div>
                            </div>

                            <!-- Edit -->
                            <div class="relative group inline-block">
                                <a href="{{ route('categories.edit', $category['id']) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded transition duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                </a>
                                <div
                                    class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 bg-black text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition duration-200 pointer-events-none">
                                    Edit
                                </div>
                            </div>

                            <!-- Delete -->
                            <div class="relative group inline-block">
                                <form action="{{ route('categories.destroy', $category['id']) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white p-2 rounded transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0 011-1z" />
                                        </svg>
                                    </button>
                                </form>
                                <div
                                    class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 bg-black text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition duration-200 pointer-events-none">
                                    Delete
                                </div>
                            </div>

                            <!-- Modal -->
                            <div x-show="open" @click.away="open = false"
                                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                                    <h2 class="text-lg font-bold mb-4">Category Details</h2>
                                    <p class="mb-2"><strong>Name:</strong> <span x-text="category.categoryName ?? '-'"></span></p>
                                    <p class="mb-2"><strong>Created By:</strong> <span>{{ $fullName }}</span></p>
                                    <p class="mb-2"><strong>Created At:</strong> {{ \Carbon\Carbon::parse($category['createdAt'])->format('d M Y h:i A') }}</p>
                                    <p class="mb-2"><strong>Updated At:</strong> {{ \Carbon\Carbon::parse($category['updatedAt'])->format('d M Y h:i A') }}</p>

                                    <div class="mt-4 text-right">
                                        <button @click="open = false"
                                            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if(isset($meta) && $meta['pageCount'] > 1)
        @php
            $currentPage = (int)($meta['currentPage'] ?? 1);
            $pageCount = (int)($meta['pageCount']);
            $hasPrev = !is_null($meta['previousPage']);
            $hasNext = !is_null($meta['nextPage']);
        @endphp

        <div class="mt-4 flex justify-center items-center space-x-2">
            @if($hasPrev)
                <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage - 1]) }}"
                    class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 transition">
                    ← Previous
                </a>
            @endif

            <span class="px-3 py-1 bg-gray-200 border border-gray-300 rounded">
                Page {{ $currentPage }} of {{ $pageCount }}
            </span>

            @if($hasNext)
                <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage + 1]) }}"
                    class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 transition">
                    Next →
                </a>
            @endif
        </div>
    @endif

@else
    <p class="text-sm text-red-500">No {{ strtolower($title) }} found.</p>
@endif
@endsection
