@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-[25px] font-medium mb-4">Users</h1>
    <div class="flex">
        <div onclick="location.reload()" class="w-32 text-center text-sm rounded font-medium text-[#5e1f1b] mb-2 p-2 mr-4 bg-white border border-[#7A2B26] flex items-center justify-center gap-1 cursor-pointer hover:bg-[#f3eae9] hover:border-[#5e1f1b] transition-colors duration-200">
            <img src="{{ asset('images/icons/refresh-icon.png') }}" class="w-4 h-4" alt="Plus Icon">
            Refresh Data
        </div>
        <a href="{{ route('admin.user.add') }}">
            <div class="w-32 text-center text-sm rounded font-medium mb-2 p-2 bg-gradient-to-r from-[#BF360C] to-[#6D4C41] text-white flex items-center justify-center gap-1 cursor-pointer hover:from-[#943732] hover:to-[#4D322D] transition-colors duration-200">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Add Users
            </div>
        </a>
    </div>
</div>

@if (isset($users) && is_array($users) && count($users) > 0)
<div class="overflow-x-auto rounded-xl shadow-md bg-white">
    <div class="min-w-max">
        <table class="minfull divide-y divide-gray-200 text-sm text-gray-800">
            <thead>
                <tr class="bg-gradient-to-r from-[#BF360C] to-[#6D4C41] text-white uppercase text-xs text-left">
                    <th class="px-5 py-3 rounded-tl-xl">S/No</th>
                    <th class="px-5 py-3">Name</th>
                    <th class="px-5 py-3">Username</th>
                    <th class="px-5 py-3">Email</th>
                    <th class="px-5 py-3">Mobile</th>
                    <th class="px-5 py-3">Last Login</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3 rounded-tr-xl">Actions</th>
                </tr>
                <!-- Search Inputs Row -->
                <tr class="bg-[#F5F5F5] text-sm text-[#212121]">
                    <th class="px-5 py-2 w-20"><input type="text" class="w-auto bg-white border border-gray-300 rounded px-2 py-1 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-[#BF360C]" placeholder="Search S/No" disabled></th>
                    <th class="px-5 py-2"><input type="text" class="w-full bg-white border border-gray-300 rounded px-2 py-1 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-[#BF360C]" placeholder="Search Name"></th>
                    <th class="px-5 py-2"><input type="text" class="w-full bg-white border border-gray-300 rounded px-2 py-1 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-[#BF360C]" placeholder="Search Username"></th>
                    <th class="px-5 py-2"><input type="text" class="w-full bg-white border border-gray-300 rounded px-2 py-1 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-[#BF360C]" placeholder="Search Email"></th>
                    <th class="px-5 py-2"><input type="text" class="w-full bg-white border border-gray-300 rounded px-2 py-1 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-[#BF360C]" placeholder="Search Mobile"></th>
                    <th class="px-5 py-2"><input type="text" class="w-full bg-white border border-gray-300 rounded px-2 py-1 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-[#BF360C]" placeholder="Search Last Login"></th>
                    <th class="px-5 py-2"><input type="text" class="w-full bg-white border border-gray-300 rounded px-2 py-1 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-[#BF360C]" placeholder="Search Status"></th>
                    <th class="px-5 py-2"><input type="text" class="w-full bg-white border border-gray-300 rounded px-2 py-1 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-[#BF360C]" placeholder="-" disabled></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $user)
                <tr class="odd:bg-white even:bg-gray-50 hover:shadow-sm hover:bg-gray-100 transition duration-200">
                    <td class="px-5 py-4 text-sm text-gray-700 font-medium">
                        {{ $index + 1 }}
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-700">
                        {{ ($user['firstName'] ?? '') . ' ' . ($user['lastName'] ?? '') ?: '-' }}
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-700">
                        {{ $user['userName'] ?? '-' }}
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-700">
                        {{ $user['userName'] ?? '-' }}
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-700">
                        {{ $user['mobileNo'] ?? '-' }}
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-700">
                        {{ isset($user['lastLoginDate']) ? \Carbon\Carbon::parse($user['lastLoginDate'])->format('d M Y') : '-' }}
                    </td>
                    <td class="px-5 py-4 text-sm ">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                {{ $user['status'] === 'ACTIVE' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-700' }}">
                            {{ $user['status'] }}
                        </span>
                    </td>
                    <td class="px-5 text-sm text-left">
                        <div class="flex items-center space-x-2">
                            <!-- View -->
                            <div class="relative group inline-block">
                                <button onclick='openModal(@json($user), true)' class="bg-red-600 hover:bg-red-700 text-white p-2 rounded transition duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <!-- Tooltip -->
                                <div class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 bg-black text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition duration-200 pointer-events-none">
                                    View
                                </div>
                            </div>

                            <!-- Edit -->
                            <div class="relative group inline-block">
                                <a href="#" class="inline-flex items-center justify-center bg-[#6D4C41] hover:bg-[#53362F] text-white p-2 rounded transition duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                </a>
                                <!-- Tooltip -->
                                <div class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 bg-black text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition duration-200 pointer-events-none">
                                    Edit
                                </div>
                            </div>

                            <!-- Delete -->
                            <div class="relative group inline-block">
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white p-2 rounded transition duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0 011-1z" />
                                    </svg>
                                </button>
                                <!-- Tooltip -->
                                <div class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 bg-black text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition duration-200 pointer-events-none">
                                    Delete
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
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
@endif
@else
<p class="text-red-500">No users found or error in fetching data.</p>
@endif
@endsection

{{-- 🔥 Modal With Approve & Reject Buttons --}}
<div id="userModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-2xl p-8 relative text-black animate-fadeIn">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-red-600 text-2xl">&times;</button>
        <h2 class="text-2xl font-semibold mb-6 text-center border-b pb-3">User Details</h2>

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
    </div>
</div>

<script>
    let selectedUser = null;

    function openModal(user, showActions = true) {
        selectedUser = user;
        const modalStatus = document.getElementById('modalStatus');

        modalStatus.textContent = user.status;
        modalStatus.className = 'font-semibold text-sm px-3 py-1 rounded-full ' +
            (user.status === 'ACTIVE' ? 'bg-green-100 text-green-700 inline-block' : (user.status === 'REJECTED' ? 'bg-red-100 text-red-700 inline-block' :
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
        document.getElementById('modalIsWhatsapp')?.classList.toggle('hidden', !user.isWhatsapp);
        document.getElementById('modalIsSignal')?.classList.toggle('hidden', !user.isSignal);
        document.getElementById('modalRemarks').innerText = user.remarks || '-';
        document.getElementById('modalCreatedAt').innerText = user.createdAt ?
            new Date(user.createdAt).toLocaleDateString('en-GB', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            }) : '-';


        document.getElementById('userModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('userModal').classList.add('hidden');
    }
</script>