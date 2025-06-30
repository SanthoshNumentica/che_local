@extends('layouts.admin')

@section('title', 'Master Data')

@section('content')
<div class="text-black">

    <!-- Navigation Tabs -->
    <div class="flex space-x-4 mb-6">
        <a href="{{ route('admin.master-data', ['type' => 'growth']) }}"
            class="px-6 py-2 border-b-4 {{ $type === 'growth' ? 'border-[#7A2B26] text-[#7A2B26] font-semibold' : 'border-transparent text-gray-600 hover:text-[#7A2B26]' }}">
            Growth Categories
        </a>

        <a href="{{ route('admin.master-data', ['type' => 'project']) }}"
            class="px-6 py-2 border-b-4 {{ $type === 'project' ? 'border-[#7A2B26] text-[#7A2B26] font-semibold' : 'border-transparent text-gray-600 hover:text-[#7A2B26]' }}">
            Project Categories
        </a>

        <a href="{{ route('admin.master-data', ['type' => 'stories']) }}"
            class="px-6 py-2 border-b-4 {{ $type === 'stories' ? 'border-[#7A2B26] text-[#7A2B26] font-semibold' : 'border-transparent text-gray-600 hover:text-[#7A2B26]' }}">
            Stories Categories
        </a>

        <a href="{{ route('admin.master-data', ['type' => 'training']) }}"
            class="px-6 py-2 border-b-4 {{ $type === 'training' ? 'border-[#7A2B26] text-[#7A2B26] font-semibold' : 'border-transparent text-gray-600 hover:text-[#7A2B26]' }}">
            Training Categories
        </a>
    </div>

    <!-- Conditional Tabs -->
    @if ($type === 'growth')
        @include('partials._category_table', [
            'title' => 'Growth Categories',
            'data' => $categories
        ])  
    @endif

    @if ($type === 'project')
        @include('partials._category_table', [
            'title' => 'Project Categories',
            'data' => $projectCategories
        ])
    @endif

    @if ($type === 'stories')
        @include('partials._category_table', [
            'title' => 'Stories Categories',
            'data' => $storiesCategories
        ])
    @endif

    @if ($type === 'training')
        @include('partials._category_table', [
            'title' => 'Training Categories',
            'data' => $trainingCategories
        ])
    @endif

</div>
@endsection
