@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<h1 class="text-xl font-bold mb-4">User ID: {{ $userId }}</h1>
<p>Show user details here.</p>
@endsection