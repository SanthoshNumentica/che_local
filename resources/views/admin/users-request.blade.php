@php
use Illuminate\Support\Str;
@endphp
@extends('layouts.admin')
@section('title', 'Users Request')
@section('content')

<div class="flex items-center justify-between mb-4">
    <h1 class="text-[25px] font-medium mb-4">Manage Request Users</h1>
    <div class="flex">
        <div onclick="location.reload()" class="w-32 text-center text-sm rounded font-medium mb-2 p-2 mr-4 bg-white border border-[#7A2B26] flex items-center justify-center gap-1 cursor-pointer hover:bg-[#f3eae9] hover:border-[#5e1f1b] text-[#5e1f1b] transition-colors duration-200">
            <img src="{{ asset('images/icons/refresh-icon.png') }}" class="w-4 h-4" alt="Plus Icon">
            Refresh Data
        </div>
        <a href="{{ route('admin.user.add') }}">
            <div
                class="w-32 text-center text-sm rounded font-medium mb-2 p-2 bg-gradient-to-r from-[#BF360C] to-[#6D4C41] text-white flex items-center justify-center gap-1 cursor-pointer hover:from-[#943732] hover:to-[#4D322D] transition-colors duration-200">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Add Users
            </div>
        </a>
    </div>
</div>

<div class="overflow-x-auto custom-scrollbar rounded shadow">
    <div class="min-w-max">
        <table class="w-full divide-y divide-gray-200 text-sm text-gray-800">
            <thead class="bg-gradient-to-r from-[#BF360C] to-[#6D4C41] text-white uppercase text-xs text-left">
                <tr>
                    <th class="px-5 py-3 rounded-tl-xl">S/No</th>
                    <th class="px-5 py-3">Name</th>
                    <th class="px-5 py-3">Email</th>
                    <th class="px-5 py-3">Mobile</th>
                    <th class="px-5 py-3">Address</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3">Created At</th>
                    <th class="px-5 py-3">Actions</th>
                </tr>
                <!-- Search Inputs Row -->
                <tr class="bg-[#F5F5F5] text-sm text-[#212121]">
                    <th class="px-5 py-2 w-30"><input type="text" class="w-full bg-white border border-gray-300 rounded px-2 py-1 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-[#BF360C]" placeholder="Search S/No" disabled></th>
                    <th class="px-5 py-2"><input type="text" class="w-full bg-white border border-gray-300 rounded px-2 py-1 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-[#BF360C]" placeholder="Search Name"></th>
                    <th class="px-5 py-2"><input type="text" class="w-full bg-white border border-gray-300 rounded px-2 py-1 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-[#BF360C]" placeholder="Search Email"></th>
                    <th class="px-5 py-2"><input type="text" class="w-full bg-white border border-gray-300 rounded px-2 py-1 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-[#BF360C]" placeholder="Search Mobile No"></th>
                    <th class="px-5 py-2"><input type="text" class="w-full bg-white border border-gray-300 rounded px-2 py-1 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-[#BF360C]" placeholder="Search Address"></th>
                    <th class="px-5 py-2"><input type="text" class="w-full bg-white border border-gray-300 rounded px-2 py-1 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-[#BF360C]" placeholder="Search Status"></th>
                    <th class="px-5 py-2"><input type="text" class="w-full bg-white border border-gray-300 rounded px-2 py-1 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-[#BF360C]" placeholder="Search Created At"></th>
                    <th class="px-5 py-2"><input type="text" class="w-full bg-white border border-gray-300 rounded px-2 py-1 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-[#BF360C]" placeholder="-" disabled></th>
                </tr>
            </thead>
            <tbody>
                @if (isset($requests) && is_array($requests) && count($requests) > 0)
                @foreach ($requests as $index => $user)
                <tr class="odd:bg-white even:bg-gray-50 hover:shadow-sm hover:bg-gray-100 transition duration-200">
                    <td class="px-5 py-4 text-sm text-gray-700 font-medium">
                        {{ ($pagination['currentPage'] - 1) * $pagination['perPage'] + $index + 1 }}
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-700">
                        {{ ($user['firstName'] ?? '') . ' ' . ($user['lastName'] ?? '') ?: '-' }}
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-700">{{ $user['emailId'] ?? '-' }}</td>
                    <td class="px-5 py-4 text-sm text-gray-700">{{ $user['mobileNo'] ?? '-' }}</td>
                    <td class="px-5 py-4 text-sm text-gray-700">
                        {{ Str::limit($user['address'] ?? '-', 20, '...') }}
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-700">
                        <span
                            class="px-3 py-1 rounded-full text-xs font-semibold 
                                    {{ $user['status'] === 'APPROVED' ? 'bg-green-100 text-green-700' : ($user['status'] === 'REJECTED' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ $user['status'] }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-sm ">
                        {{ isset($user['createdAt']) ? \Carbon\Carbon::parse($user['createdAt'])->format('d M Y') : '-' }}
                    </td>
                    <td class="px-5 text-sm text-left">
                        <div class="flex items-center space-x-2">
                            <!-- View -->
                            <div class="relative group inline-block">
                                <button onclick='openModal(@json($user), false)'
                                    class="inline-flex items-center justify-center bg-[#BF360C] hover:bg-[#A42F0A] text-white p-2 rounded transition duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <!-- Tooltip -->
                                <div
                                    class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 bg-black text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition duration-200 pointer-events-none">
                                    View
                                </div>
                            </div>

                            <!-- Approve -->
                            @if($user['status'] !== 'APPROVED' && $user['status'] !== 'REJECTED')
                            <div class="relative group inline-block">
                                <button onclick='openModal(@json($user), true)'
                                    class="inline-flex items-center justify-center bg-[#6D4C41] hover:bg-[#53362F] text-white p-2 rounded transition duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M12 22C6.48 22 2 17.52 2 12S6.48 2 12 2s10 4.48 10 10-4.48 10-10 10z" />
                                    </svg>
                                </button>
                                <!-- Tooltip -->
                                <div
                                    class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 bg-black text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition duration-200 pointer-events-none">
                                    Approve
                                </div>
                            </div>
                            @endif
                        </div>
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
</div>

{{-- Pagination --}}
@if (!empty($pagination))
<div class="mt-8 flex flex-col items-center gap-4">
    <div class="text-sm text-gray-700">
        Page <span class="font-medium">{{ $pagination['currentPage'] }}</span> of <span
            class="font-medium">{{ $pagination['pageCount'] }}</span>
    </div>

    <div class="inline-flex items-center space-x-2">
        {{-- First Page --}}
        <a href="{{ route('admin.users.requests', ['page' => 1, 'limit' => $pagination['perPage']]) }}"
            class="px-3 py-1 text-sm rounded border bg-white hover:bg-gray-100 {{ $pagination['isFirstPage'] ? 'opacity-50 pointer-events-none' : '' }}">
            « First
        </a>

        {{-- Previous Page --}}
        <a href="{{ route('admin.users.requests', ['page' => $pagination['currentPage'] - 1, 'limit' => $pagination['perPage']]) }}"
            class="px-3 py-1 text-sm rounded border bg-white hover:bg-gray-100 {{ $pagination['isFirstPage'] ? 'opacity-50 pointer-events-none' : '' }}">
            ‹ Prev
        </a>

        {{-- Current Page (active) --}}
        <span class="px-3 py-1 text-sm rounded bg-[#BF360C] text-white font-semibold">
            {{ $pagination['currentPage'] }}
        </span>

        {{-- Next Page --}}
        <a href="{{ route('admin.users.requests', ['page' => $pagination['currentPage'] + 1, 'limit' => $pagination['perPage']]) }}"
            class="px-3 py-1 text-sm rounded border bg-white hover:bg-gray-100 {{ $pagination['isLastPage'] ? 'opacity-50 pointer-events-none' : '' }}">
            Next ›
        </a>

        {{-- Last Page --}}
        <a href="{{ route('admin.users.requests', ['page' => $pagination['pageCount'], 'limit' => $pagination['perPage']]) }}"
            class="px-3 py-1 text-sm rounded border bg-white hover:bg-gray-100 {{ $pagination['isLastPage'] ? 'opacity-50 pointer-events-none' : '' }}">
            Last »
        </a>
    </div>
</div>
@else
<p class="text-red-500">No users found or error in fetching data.</p>
@endif
@endsection

{{-- Modal With Approve & Reject Buttons --}}
<div id="userModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-2xl p-8 relative text-black animate-fadeIn">
        <button onclick="closeModal()"
            class="absolute top-4 right-4 text-gray-400 hover:text-red-600 text-2xl">&times;</button>
        <h2 class="text-2xl font-semibold mb-6 text-center border-b pb-3 text-[#BF360C]">User Request Details</h2>

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
                <p class="text-gray-600 font-medium">Mobile No</p>
                <div class="flex gap-4">
                    <p id="modalMobile" class="font-semibold text-gray-900">-</p>
                    <img id="modalIsWhatsapp" src="{{ asset('images/icons/whatsapp-icon.png') }}" class="w-6 h-6 hidden"
                        alt="WhatsApp Icon">
                    <img id="modalIsSignal" src="{{ asset('images/icons/message-icon.png') }}" class="w-6 h-6 hidden"
                        alt="Signal Icon">
                </div>
            </div>
            <div>
                <p class="text-gray-600 font-medium">Address</p>
                <p id="modalAddress" class="font-semibold text-gray-900">-</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">State</p>
                <p id="modalState" class="font-semibold text-gray-900">-</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">Country</p>
                <p id="modalCountry" class="font-semibold text-gray-900">-</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">Referrer Name</p>
                <p id="modalReferrerName" class="font-semibold text-gray-900">-</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">Referrer Email</p>
                <p id="modalReferrerEmail" class="font-semibold text-gray-900 break-all">-</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">Referrer Mobile No</p>
                <p id="modalReferrerMobile" class="font-semibold text-gray-900">-</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">Remarks</p>
                <p id="modalRemarks" class="font-semibold text-gray-900">-</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">Created At</p>
                <p id="modalCreatedAt" class="font-semibold text-gray-900">-</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">Status</p>
                <p id="modalStatus" class="font-semibold text-gray-900">-</p>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.users.approve', $user['id']) }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" id="status" value="">
            <div id="modalFooter" class="flex justify-end gap-4 border-t pt-4">
                <button type="submit" onclick="setStatusAndSubmit(event, 'REJECTED', this)"
                    class="action-button flex items-center justify-center bg-white border border-[#7A2B26] hover:bg-[#f3eae9] hover:border-[#5e1f1b] transition-colors duration-200 text-[#5e1f1b] font-medium px-4 py-2 rounded">
                    <svg class="hidden animate-spin h-5 w-5 mr-2 text-[#5e1f1b]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                    </svg>
                    <span>Reject</span>
                </button>
                <button type="submit" onclick="setStatusAndSubmit(event, 'APPROVED', this)"
                    class="action-button flex items-center justify-center bg-gradient-to-r from-[#BF360C] to-[#6D4C41] hover:from-[#943732] hover:to-[#4D322D] transition-colors duration-200 text-white font-medium px-4 py-2 rounded">
                    <svg class="hidden animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                    </svg>
                    <span>Approve</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let selectedUser = null;

    function openModal(user, showActions = true) {
        selectedUser = user;
        const modalStatus = document.getElementById('modalStatus');

        modalStatus.textContent = user.status;
        modalStatus.className = 'font-semibold text-sm px-3 py-1 rounded-full ' +
            (user.status === 'APPROVED' ? 'bg-green-100 text-green-700 inline-block' : (user.status === 'REJECTED' ? 'bg-red-100 text-red-700 inline-block' :
                'bg-yellow-100 text-yellow-800 inline-block'));


        document.getElementById('modalFirstName').innerText = user.firstName || '-';
        document.getElementById('modalLastName').innerText = user.lastName || '-';
        document.getElementById('modalEmail').innerText = user.emailId || '-';
        document.getElementById('modalMobile').innerText = user.mobileNo || '-';
        document.getElementById('modalAddress').innerText = user.address || '-';
        document.getElementById('modalState').innerText = user.admin0 || '-';
        document.getElementById('modalCountry').innerText = user.admin1 || '-';
        document.getElementById('modalReferrerName').innerText = user.referrerName || '-';
        document.getElementById('modalReferrerEmail').innerText = user.referrerEmail || '-';
        document.getElementById('modalReferrerMobile').innerText = user.referrerMobileNo || '-';
        document.getElementById('modalRemarks').innerText = user.remarks || '-';
        document.getElementById('modalIsWhatsapp')?.classList.toggle('hidden', !user.isWhatsapp);
        document.getElementById('modalIsSignal')?.classList.toggle('hidden', !user.isSignal);
        document.getElementById('modalCreatedAt').innerText = user.createdAt ?
            new Date(user.createdAt).toLocaleDateString('en-GB', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            }) : '-';


        // Show or hide action buttons
        const footer = document.getElementById('modalFooter');
        if (showActions) {
            footer.classList.remove('hidden');
        } else {
            footer.classList.add('hidden');
        }

        document.getElementById('userModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('userModal').classList.add('hidden');
    }

    function setStatusAndSubmit(event, statusValue, button) {
        event.preventDefault();

        // Disable both buttons and apply styles
        const buttons = document.querySelectorAll('.action-button');
        buttons.forEach(btn => {
            btn.disabled = true;
            btn.classList.add('opacity-60', 'cursor-not-allowed');
        });

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

        if (spinner) spinner.classList.remove('hidden');
        if (textSpan) textSpan.textContent = statusValue === 'APPROVED' ? 'Approving...' : 'Rejecting...';

        const form = button.closest('form');
        document.getElementById('status').value = statusValue;
        statusValue.value = status;

        // Submit the form
        form.submit();
    }
</script>

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