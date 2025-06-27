@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<h1 class="text-xl font-bold mb-4">Manage Request Users</h1>

<div class="overflow-x-auto rounded shadow">
    <table class="min-w-full bg-white border border-gray-300 text-sm text-left text-black">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 border-b">S/No</th>
                <th class="px-4 py-2 border-b">First Name</th>
                <th class="px-4 py-2 border-b">Last Name</th>
                <th class="px-4 py-2 border-b">Email</th>
                <th class="px-4 py-2 border-b">Mobile</th>
                <th class="px-4 py-2 border-b">Address</th>
                <th class="px-4 py-2 border-b">Status</th>
                <th class="px-4 py-2 border-b">Created At</th>
                <th class="px-4 py-2 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($requests) && is_array($requests) && count($requests) > 0)
            @foreach ($requests as $index => $user)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border-b">{{ ($pagination['currentPage'] - 1) * $pagination['pageCount'] + $index + 1 }}</td>
                <td class="px-4 py-2 border-b">{{ $user['firstName'] ?? '-' }}</td>
                <td class="px-4 py-2 border-b">{{ $user['lastName'] ?? '-' }}</td>
                <td class="px-4 py-2 border-b">{{ $user['emailId'] ?? '-' }}</td>
                <td class="px-4 py-2 border-b">{{ $user['mobileNo'] ?? '-' }}</td>
                <td class="px-4 py-2 border-b">{{ $user['address'] ?? '-' }}</td>
                <td class="px-4 py-2 border-b">
                    <span class="px-2 py-1 rounded text-xs font-semibold 
                                    {{ $user['status'] === 'APPROVED' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $user['status'] }}
                    </span>
                </td>
                <td class="px-4 py-2 border-b">
                    {{ isset($user['createdAt']) ? \Carbon\Carbon::parse($user['createdAt'])->format('d M Y, h:i A') : '-' }}
                </td>
                <td class="px-4 py-2 border-b">
                    <button onclick='openModal(@json($user))'
                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded">
                        View
                    </button>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="9" class="px-4 py-6 text-center text-gray-500">No user requests found.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if (!empty($pagination))
<div class="mt-6">
    <p>Page {{ $pagination['currentPage'] }} of {{ $pagination['pageCount'] }}</p>

    <div class="flex gap-4 mt-2">
        @if (!$pagination['isFirstPage'])
        <a href="{{ route('admin.users.requests', ['page' => $pagination['currentPage'] - 1]) }}" class="text-blue-600 hover:underline">← Previous</a>
        @endif

        @if (!$pagination['isLastPage'])
        <a href="{{ route('admin.users.requests', ['page' => $pagination['currentPage'] + 1]) }}" class="text-blue-600 hover:underline">Next →</a>
        @endif
    </div>
</div>
@endif

{{-- 🔥 Modal With Approve & Reject Buttons --}}
<div id="userModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-2xl p-8 relative text-black animate-fadeIn">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-red-600 text-2xl">&times;</button>
        <h2 class="text-2xl font-semibold mb-6 text-center border-b pb-3">User Request Details</h2>

        <div class="grid grid-cols-2 gap-6 text-sm mb-6">
            <div>
                <p class="text-gray-600 font-medium">First Name</p>
                <p id="modalFirstName" class="font-semibold text-gray-900">-</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">Last Name</p>
                <p id="modalLastName" class="font-semibold text-gray-900">-</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">Email</p>
                <p id="modalEmail" class="font-semibold text-gray-900 break-all">-</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">Mobile</p>
                <p id="modalMobile" class="font-semibold text-gray-900">-</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">Address</p>
                <p id="modalAddress" class="font-semibold text-gray-900">-</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">Status</p>
                <p id="modalStatus" class="font-semibold text-gray-900">-</p>
            </div>
            <div class="col-span-2">
                <p class="text-gray-600 font-medium">Remarks</p>
                <p id="modalRemarks" class="font-semibold text-gray-900">-</p>
            </div>
            <div class="col-span-2">
                <p class="text-gray-600 font-medium">Created At</p>
                <p id="modalCreatedAt" class="font-semibold text-gray-900">-</p>
            </div>
        </div>

        <div class="flex justify-end gap-4 border-t pt-4">
            <button onclick="handleApprove()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                APPROVE
            </button>
            <button onclick="handleReject()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                REJECT
            </button>
        </div>
    </div>
</div>

{{-- ✨ Scripts --}}
<script>
    let selectedUser = null;

    function openModal(user) {
        selectedUser = user;

        document.getElementById('modalFirstName').innerText = user.firstName || '-';
        document.getElementById('modalLastName').innerText = user.lastName || '-';
        document.getElementById('modalEmail').innerText = user.emailId || '-';
        document.getElementById('modalMobile').innerText = user.mobileNo || '-';
        document.getElementById('modalAddress').innerText = user.address || '-';
        document.getElementById('modalStatus').innerText = user.status || '-';
        document.getElementById('modalRemarks').innerText = user.remarks || '-';
        document.getElementById('modalCreatedAt').innerText = user.createdAt ?
            new Date(user.createdAt).toLocaleString() :
            '-';

        document.getElementById('userModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('userModal').classList.add('hidden');
    }

    function handleApprove() {
        if (!selectedUser || !selectedUser.id) {
            alert("User ID not found.");
            return;
        }

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/admin/users/approve/${selectedUser.id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                status: 'APPROVED'
            })
        })
        console.error('error', err)
            .then(response => {
                if (!response.ok) throw new Error("Approval failed");
                return response.json();
            })
            .then(data => {
                alert(`User ${selectedUser.firstName} approved successfully!`);
                window.location.reload(); // Optionally reload or remove row
            })
            .catch(error => {
                alert('Failed to approve user. Please try again.');
                console.error(error);
            });

        closeModal();
    }

    function handleReject() {
        alert(`Rejected request for: ${selectedUser.firstName} ${selectedUser.lastName}`);
        closeModal();
    }
</script>

{{-- Optional: fadeIn animation if you use Tailwind’s animation plugin --}}
<style>
    .animate-fadeIn {
        animation: fadeIn 0.25s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection