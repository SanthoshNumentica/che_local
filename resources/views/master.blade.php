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

    <!-- Content based on tab -->
    @if ($type === 'growth')
        @include('partials._category_table', [
            'title' => 'Growth Categories',
            'data' => $categories,
            'meta' => $meta,
        ])
    @elseif ($type === 'project')
        @include('partials._category_table', [
            'title' => 'Project Categories',
            'data' => $projectCategories,
            'meta' => $meta,
        ])
    @elseif ($type === 'stories')
        @include('partials._category_table', [
            'title' => 'Stories Categories',
            'data' => $storiesCategories,
            'meta' => $meta,
        ])
    @elseif ($type === 'training')
        @include('partials._category_table', [
            'title' => 'Training Categories',
            'data' => $trainingCategories,
            'meta' => $meta,
        ])
    @endif

</div>
@endsection
