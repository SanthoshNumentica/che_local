<div class="flex items-center justify-between mb-4">
    <h1 class="text-[25px] font-medium">{{ $title }}</h1>

    <div class="flex gap-2">
        <div onclick="toggleModal()" 
            class="w-32 text-center text-sm rounded font-medium text-[#5e1f1b] p-2 bg-white border border-[#7A2B26] bg-gradient-to-r from-[#BF360C] to-[#6D4C41] text-white flex items-center justify-center gap-1 cursor-pointer hover:bg-[#f3eae9] hover:border-[#5e1f1b] transition-colors duration-200">
            Add
    </div>
    <div onclick="location.reload()"
        class="w-32 text-center text-sm rounded font-medium text-[#5e1f1b] p-2 bg-white border border-[#7A2B26] flex items-center justify-center gap-1 cursor-pointer hover:bg-[#f3eae9] hover:border-[#5e1f1b] transition-colors duration-200">
        <img src="{{ asset('images/icons/refresh-icon.png') }}" class="w-4 h-4" alt="Refresh Icon">
        Refresh Data
    </div>
</div>
</div>

<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96 relative">

        
        <button onclick="toggleModal()"
            class="absolute top-2 right-2 text-gray-600 hover:text-red-600 text-2xl font-bold focus:outline-none">
            &times;
        </button>

        <label for="categoryName" class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
        <input type="text" id="categoryName" name="categoryName"
            class="w-full px-4 py-2 border border-gray-300 rounded mb-4" />

        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
        <select id="status" name="status"
            class="w-full px-2 py-2 border border-gray-300 rounded mb-4 bg-white">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>

        <div class="flex justify-end">
            <button onclick="toggleModal()"
                class="px-4 py-2 rounded bg-gradient-to-r from-[#BF360C] to-[#6D4C41] text-white hover:from-[#943732] hover:to-[#4D322D]">
                Create
            </button>
        </div>
    </div>
</div>




@if (count($data) > 0)
<div class="w-full overflow-x-auto rounded-xl shadow bg-white">
    <table class="w-full divide-y divide-gray-200 text-sm text-gray-800">
        <thead>
            <tr class="bg-gradient-to-r from-[#BF360C] to-[#6D4C41] text-white uppercase text-xs text-left">
                <th class="px-5 py-3 rounded-tl-xl">S/No</th>
                <th class="px-5 py-3">Category Name</th>
                <th class="px-5 py-3">Created By</th>
                <th class="px-5 py-3">Created At</th>
                <th class="px-5 py-3">Updated At</th>
                <th class="px-5 py-3 rounded-tr-xl text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $category)
            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition duration-200">
                <td class="px-5 py-4">{{ $index + 1 }}</td>
                <td class="px-5 py-4">{{ $category['categoryName'] ?? '-' }}</td>
                <td class="px-5 py-4">
                    {{
                        $category['createdByUser']['fullName'] ??
                        trim(($category['createdByUser']['firstName'] ?? '') . ' ' . ($category['createdByUser']['lastName'] ?? '')) ?: '-'
                    }}
                </td>
                <td class="px-5 py-4">
                    {{ isset($category['createdAt']) ? \Carbon\Carbon::parse($category['createdAt'])->format('d M Y h:i A') : '-' }}
                </td>
                <td class="px-5 py-4">
                    {{ isset($category['updatedAt']) ? \Carbon\Carbon::parse($category['updatedAt'])->format('d M Y h:i A') : '-' }}
                </td>
                <td class="px-5 py-4 flex justify-center space-x-2">

                    <!-- View -->
                    <div class="relative group inline-block">
                        <button onclick='openModal(@json($category), true)' class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                        <div
                            class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 bg-black text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition duration-200 pointer-events-none">
                            View
                        </div>
                    </div>

                    <!-- Edit -->

                    <div class="relative group inline-block">
                 <button onclick='openEditModal(@json($category))'
               class="flex items-center justify-center bg-[#6D4C41] hover:bg-[#53362F] text-white p-2 rounded transition duration-200">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                 </svg>
           </button>
         <div
        class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 transform bg-black text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition duration-200 pointer-events-none">
        Edit
    </div>
</div>

                    <!-- Delete -->
                    <div class="relative group inline-block">
                        <form method="POST" action="#">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="openDeleteModal()" class="bg-red-600 hover:bg-red-700 text-white p-2 rounded transition duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0 011-1z" />
                                </svg>
                            </button>
                        </form>
                        <div
                            class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 bg-black text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition duration-200 pointer-events-none">
                            Delete
                        </div>
                    </div>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<footer class="fixed bottom-0 right-0 mb-2 mr-4 text-sm text-gray-500 italic z-50">
    Developed by @ITOI Technologies
</footer>

@else
<p class="text-sm text-red-500">No {{ strtolower($title) }} found.</p>
@endif



                    <!-- Category Modal -->
<div id="categoryModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex items-center justify-center">
    <div class="bg-white shadow-lg w-full max-w-xl p-8 relative text-black animate-fadeIn">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-red-600 text-2xl">&times;</button>
    
        <h2 class="text-2xl font-semibold mb-6 text-center border-b pb-3">Category Details</h2>

        <div class="grid grid-cols-2 gap-6 text-sm mb-6">
            <div>
                <p class="text-gray-600 font-medium">Category Name</p>
                <p id="categoryModalName" class="font-semibold text-gray-900">-</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">Created By</p>
                <p id="categoryModalCreatedBy" class="font-semibold text-gray-900">-</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">Created At</p>
                <p id="categoryModalCreatedAt" class="font-semibold text-gray-900">-</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">Updated At</p>
                <p id="categoryModalUpdatedAt" class="font-semibold text-gray-900">-</p>
            </div>
        </div>
    </div>
</div>


                       <!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-8 relative text-black">
        <button onclick="closeEditModal()" class="absolute top-4 right-4 text-gray-400 hover:text-red-600 text-2xl">&times;</button>
        <h2 class="text-xl font-semibold mb-6 text-center border-b pb-3">Edit</h2>

        <form id="editForm">
            <input type="hidden" id="editId">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                <input type="text" id="editName" required
                    class="w-full px-2 py-2 border border-gray-300 rounded" />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Created By</label>
                <input type="text" id="editCreatedBy" required
                    class="w-full px-2 py-2 border border-gray-300 rounded" />
            </div>

            <div class="text-end">
                <button type="submit" class="px-4 py-2 rounded bg-gradient-to-r from-[#BF360C] to-[#6D4C41] text-white hover:from-[#943732] hover:to-[#4D322D]">Update</button>    
            </div>
        </form>
    </div>
</div>


<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex items-center justify-center">
    <div class="bg-white p-6 rounded-xl shadow-lg text-center w-full max-w-sm relative">
        <button onclick="closeDeleteModal()"
            class="absolute top-4 right-4 text-gray-400 hover:text-red-600 text-2xl font-bold">
            &times;
        </button>

        <h2 class="text-lg font-semibold mb-4 mt-2">Are you sure you want to delete?</h2>
        <div class="flex justify-center gap-4">
            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Yes</button>
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">No</button>
        </div>
    </div>
</div>


<script>
    function openModal(category) {
        
        const createdBy = category.createdByUser?.fullName ||
            ((category.createdByUser?.firstName || '') + ' ' + (category.createdByUser?.lastName || '')).trim();

        document.getElementById('categoryModalName').innerText = category.categoryName || '-';

        document.getElementById('categoryModalCreatedBy').innerText = createdBy || '-';

        document.getElementById('categoryModalCreatedAt').innerText = category.createdAt
        ? new Date(category.createdAt).toLocaleDateString('en-GB', {
           day: '2-digit',
           month: 'short', 
           year: 'numeric'
    })
    : '-';

    document.getElementById('categoryModalUpdatedAt').innerText = category.updatedAt
    ? new Date(category.updatedAt).toLocaleDateString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    })
    : '-';

        document.getElementById('categoryModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('categoryModal').classList.add('hidden');
    }


    function toggleModal() {
        document.getElementById('modal').classList.toggle('hidden');
    }

    
    function openEditModal(category) {
        document.getElementById('editId').value = category.id || '';
        document.getElementById('editName').value = category.categoryName || '';
        document.getElementById('editCreatedBy').value =
            category.createdByUser?.fullName ||
            `${category.createdByUser?.firstName || ''} ${category.createdByUser?.lastName || ''}`.trim();

        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }


    function openDeleteModal() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    </script>