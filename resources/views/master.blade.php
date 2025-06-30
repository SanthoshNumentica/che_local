@extends('layouts.admin')

@section('title', 'Master Data')

@section('content')
<div class="text-black">

    <!-- Navigation Tabs -->
    <div class="flex space-x-4 mb-6">
        @foreach (['growth', 'project', 'stories', 'training'] as $tab)
            <a href="{{ route('admin.master-data', ['type' => $tab]) }}"
                class="px-6 py-2 border-b-4 {{ $type === $tab ? 'border-[#7A2B26] text-[#7A2B26] font-semibold' : 'border-transparent text-gray-600 hover:text-[#7A2B26]' }}">
                {{ ucfirst($tab) }} Categories
            </a>
        @endforeach
    </div>

    <!-- Table Partial -->
    @php
        $tableData = match($type) {
            'growth' => $categories,
            'project' => $projectCategories,
            'stories' => $storiesCategories,
            'training' => $trainingCategories,
            default => []
        };
        $title = ucfirst($type) . ' Categories';
    @endphp

    @include('partials._category_table', [
        'title' => $title,
        'data' => $tableData,
        'meta' => $meta,
        'type' => $type,
        'limit' => $limit,
    ])

</div>
@endsection
