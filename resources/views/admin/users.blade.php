@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <h1 class="text-xl font-bold mb-4">Manage Users</h1>

    @if (isset($users) && is_array($users) && count($users) > 0)
        <div class="overflow-x-auto rounded shadow">
            <table class="min-w-full bg-white border border-gray-300 text-sm text-left text-black">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border-b">S/No</th>
                        <th class="px-4 py-2 border-b">First Name</th>
                        <th class="px-4 py-2 border-b">Last Name</th>
                        <th class="px-4 py-2 border-b">Username</th>
                        <th class="px-4 py-2 border-b">Email</th>
                        <th class="px-4 py-2 border-b">Mobile</th>
                        <th class="px-4 py-2 border-b">Last Login</th>
                        <th class="px-4 py-2 border-b">Status</th>
                        <th class="px-4 py-2 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border-b">{{ $user['firstName'] ?? '-' }}</td>
                            <td class="px-4 py-2 border-b">{{ $user['lastName'] ?? '-' }}</td>
                            <td class="px-4 py-2 border-b">{{ $user['userName'] ?? '-' }}</td>
                            <td class="px-4 py-2 border-b">{{ $user['userName'] ?? '-' }}</td>
                            <td class="px-4 py-2 border-b">{{ $user['mobileNo'] ?? '-' }}</td>
                            <td class="px-4 py-2 border-b">
                                {{ isset($user['lastLoginDate']) ? \Carbon\Carbon::parse($user['lastLoginDate'])->format('d M Y, h:i A') : '-' }}
                            </td>
                            <td class="px-4 py-2 border-b">
                                <span class="px-2 py-1 rounded text-xs font-semibold 
                                    {{ $user['status'] === 'ACTIVE' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $user['status'] }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border-b">
                                <a href="{{ route('admin.users.view', ['id' => $user['userId']]) }}"
                                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if (!empty($pagination))
            <div class="mt-6">
                <p>Page {{ $pagination['currentPage'] }} of {{ $pagination['pageCount'] }}</p>

                <div class="flex gap-4 mt-2">
                    @if (!$pagination['isFirstPage'])
                        <a href="{{ route('admin.users', ['page' => $pagination['currentPage'] - 1]) }}" class="text-blue-600 hover:underline">← Previous</a>
                    @endif

                    @if (!$pagination['isLastPage'])
                        <a href="{{ route('admin.users', ['page' => $pagination['currentPage'] + 1]) }}" class="text-blue-600 hover:underline">Next →</a>
                    @endif
                </div>
            </div>
        @endif
    @else
        <p class="text-red-500">No users found or error in fetching data.</p>
    @endif
@endsection
