<div id="userModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-lg animate-fadeIn relative">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl font-bold">×</button>
        <h2 class="text-xl font-semibold mb-4 text-[#7A2B26]">User Profile</h2>
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
                <p class="text-gray-600 font-medium">Status</p>
                <p id="modalStatus" class="font-semibold text-gray-900">-</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">Last Login</p>
                <p id="modalLastLogin" class="font-semibold text-gray-900">-</p>
            </div>
            <div class="col-span-2">
                <p class="text-gray-600 font-medium">Created At</p>
                <p id="modalCreatedAt" class="font-semibold text-gray-900">-</p>
            </div>
        </div>
    </div>
</div>
