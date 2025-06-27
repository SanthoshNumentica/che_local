@extends('layouts.admin')

@section('title', 'Master Data')

@section('content')
<div x-data="{ tab: 'growth' }" class="text-black">
    <!-- Tabs -->
    <div class="flex space-x-4 border-b mb-4">
        <button @click="tab = 'growth'" :class="tab === 'growth' ? 'border-b-2 border-[#7A2B26] text-[#7A2B26]' : 'text-gray-600'"
            class="px-4 py-2 font-medium">Growth Categories</button>
        <button @click="tab = 'somethingElse'" :class="tab === 'somethingElse' ? 'border-b-2 border-[#7A2B26] text-[#7A2B26]' : 'text-gray-600'"

            <!-- Add more buttons as needed -->
    </div>

    <!-- Growth Categories Tab Content -->
    <div x-show="tab === 'growth'" x-cloak>
        <h1 class="text-xl font-medium mb-4">Growth Categories</h1>
        @if (isset($categories) && is_array($categories) && count($categories) > 0)
        <div class="overflow-x-auto rounded shadow">
            <table class="min-w-full bg-white border border-gray-300 text-sm text-left text-black">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border-b">S/No</th>
                        <th class="px-4 py-2 border-b">Category Name</th>
                        <th class="px-4 py-2 border-b">Created By</th>
                        <th class="px-4 py-2 border-b">Created At</th>
                        <th class="px-4 py-2 border-b">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $index => $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border-b">{{ $category['categoryName'] ?? '-' }}</td>
                        <td class="px-4 py-2 border-b">{{ $category['createdBy'] ?? '-' }}</td>
                        <td class="px-4 py-2 border-b">
                            {{ isset($category['createdAt']) ? \Carbon\Carbon::parse($category['createdAt'])->format('d M Y h:i A') : '-' }}
                        </td>
                        <td class="px-4 py-2 border-b">
                            {{ isset($category['createdAt']) ? \Carbon\Carbon::parse($category['createdAt'])->format('d M Y h:i A') : '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-red-500 mt-4">No categories found.</p>
        @endif
    </div>

    <!-- Another Tab Example -->
    <div x-show="tab === 'somethingElse'" x-cloak>
        <p class="text-gray-700"></p>
    </div>
</div>
@endsection