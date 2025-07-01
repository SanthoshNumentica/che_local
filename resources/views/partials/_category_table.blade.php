<div class="flex items-center justify-between mb-4">
    <h1 class="text-[25px] font-medium">{{ $title }}</h1>
    <div onclick="location.reload()"
        class="w-32 text-center text-sm rounded font-medium text-[#5e1f1b] p-2 bg-white border border-[#7A2B26] flex items-center justify-center gap-1 cursor-pointer hover:bg-[#f3eae9] hover:border-[#5e1f1b] transition-colors duration-200">
        <img src="{{ asset('images/icons/refresh-icon.png') }}" class="w-4 h-4" alt="Refresh Icon">
        Refresh Data
    </div>
</div>

@if (count($data) > 0)

    {{-- Page info --}}
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
                    <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition duration-200">
                        <td class="px-5 py-4">{{ $index + 1 }}</td>
                        <td class="px-5 py-4">{{ $category['categoryName'] ?? '-' }}</td>
                        <td class="px-5 py-4">
                            {{
                                $category['createdByUser']['fullName'] ??
                                trim(($category['createdByUser']['firstName'] ?? '') . ' ' . ($category['createdByUser']['lastName'] ?? '')) ?: '-'
                            }}
                        </td>
                        <td class="px-5 py-4">
                            {{ isset($category['createdAt']) ? \Carbon\Carbon::parse($category['createdAt'])->format('d M Y h:i A') : '-' }}
                        </td>
                        <td class="px-5 py-4">
                            {{ isset($category['updatedAt']) ? \Carbon\Carbon::parse($category['updatedAt'])->format('d M Y h:i A') : '-' }}
                        </td>
                        <td class="px-5 py-4 flex justify-center space-x-2">
                            <button class="px-2 py-1 text-xs text-white bg-blue-600 rounded">Edit</button>
                            <button class="px-2 py-1 text-xs text-white bg-red-600 rounded">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if(isset($meta) && isset($meta['pageCount']) && $meta['pageCount'] > 1)
        @php
            $currentPage = (int)($meta['currentPage'] ?? 1);
            $pageCount = (int)($meta['pageCount'] ?? 1);
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
