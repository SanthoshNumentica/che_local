@extends('layouts.admin')

@section('title', 'Add User')

@section('content')
<h1 class="text-[25px] font-medium mb-4">Add User</h1>

@if(session('success'))
<div class="bg-green-100 text-green-800 p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="bg-red-100 text-red-800 p-3 rounded mb-4">
    <ul class="list-disc pl-5">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form id="userForm" action="{{ route('admin.user.save') }}" method="POST">
    @csrf
    <div class="flex gap-8 mb-4">
        <div class="w-full md:w-1/2">
            <label for="first_name" class="block text-gray-700 font-medium">First Name</label>
            <input type="text" id="first_name" name="first_name" class="form-input-theme" placeholder="Enter first name" required>
        </div>
        <div class="w-full md:w-1/2">
            <label for="last_name" class="block text-gray-700 font-medium">Last Name</label>
            <input type="text" id="last_name" name="last_name" class="form-input-theme" placeholder="Enter last name" required>
        </div>
    </div>

    <div class="flex gap-8 mb-4">
        <div class="w-full md:w-1/2">
            <label for="email" class="block text-gray-700 font-medium">Email</label>
            <input type="email" id="email" name="email" class="form-input-theme" placeholder="Enter email name" required>
        </div>
        <div class="w-full md:w-1/2 mb-4">
            <label for="password" class="block text-gray-700 font-medium">Password</label>
            <div class="relative">
                <input type="password" id="password" name="password" class="form-input-theme pr-10" placeholder="Choose a secure password" required>
                <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                    <img id="eye-open" src="{{ asset('images/icons/eye_open-icon.png') }}" class="w-5 h-5" alt="Show Password">
                    <img id="eye-close" src="{{ asset('images/icons/eye_close-icon.png') }}" class="w-5 h-5 hidden" alt="Hide Password">
                </button>
            </div>
        </div>
    </div>
    <div class="flex gap-8 mb-4">
        <div class="w-full md:w-1/2">
            <label for="mobile_no" class="block text-gray-700 font-medium">Mobile No</label>
            <div class="flex items-center gap-2">
                <select id="country_code" name="country_code" class="form-input-theme w-20">
                    <option value="+91" selected>+91</option>
                    <option value="+1">+1</option>
                    <option value="+44">+44</option>
                    <option value="+61">+61</option>
                    <!-- Add more as needed -->
                </select>
                <input type="text" id="mobile_number" name="mobile_number" class="form-input-theme flex-1" required placeholder="Enter mobile number" maxlength="15" inputmode="numeric">
                <input type="hidden" id="mobile_no" name="mobile_no">
            </div>
        </div>
        <div class="w-full md:w-1/2">
            <label for="address" class="block text-gray-700 font-medium">Address</label>
            <input type="text" id="address" name="address" class="form-input-theme" placeholder="Enter address" required>
        </div>
    </div>
    <div class="flex gap-8 mb-4">
        <!-- Checkboxes row -->
        <div class="w-full md:w-1/2">
            <label class="block text-gray-700 font-medium mb-2">Choose Contact Notification Type</label>
            <div class="flex gap-4">
                <!-- WhatsApp -->
                <label class="relative">
                    <input type="checkbox" name="is_whatsapp" id="is_whatsapp" class="sr-only peer" onclick="toggleExclusive(this)" checked>
                    <div class="w-full flex items-center gap-2 px-4 py-2 border rounded-lg cursor-pointer text-gray-600 border-gray-300 hover:border-[#7A2B26] 
                        peer-checked:text-[#7A2B26] peer-checked:border-[#7A2B26] peer-checked:bg-[#fef1ef] transition">
                        <img src="{{ asset('images/icons/whatsapp-icon.png') }}" class="w-5 h-5" alt="WhatsApp Icon">
                        <span class="text-sm font-medium">WhatsApp</span>
                    </div>
                </label>

                <!-- Signal -->
                <label class="relative">
                    <input type="checkbox" name="is_onesignal" id="is_onesignal" class="sr-only peer" onclick="toggleExclusive(this)">
                    <div class="w-full flex items-center gap-2 px-4 py-2 border rounded-lg cursor-pointer text-gray-600 border-gray-300 hover:border-[#7A2B26] 
                        peer-checked:text-[#7A2B26] peer-checked:border-[#7A2B26] peer-checked:bg-[#fef1ef] transition">
                        <img src="{{ asset('images/icons/message-icon.png') }}" class="w-5 h-5" alt="Signal Icon">
                        <span class="text-sm font-medium">Signal</span>
                    </div>
                </label>
            </div>
        </div>
        <div class="w-full md:w-1/2">
            <label for="state" class="block text-gray-700 font-medium">State</label>
            <input type="text" id="state" name="state" class="form-input-theme" placeholder="Enter state name">
        </div>
    </div>
    <div class="flex gap-8 mb-4">
        <div class="w-full md:w-1/2">
            <label for="country" class="block text-gray-700 font-medium">Country</label>
            <input type="text" id="country" name="country" class="form-input-theme" value="India">
        </div>
        <div class="w-full md:w-1/2">
            <label for="referrer_name" class="block text-gray-700 font-medium">Referrer Name</label>
            <input type="text" id="referrer_name" name="referrer_name" class="form-input-theme" placeholder="Enter referrer name">
        </div>
    </div>
    <div class="flex gap-8 mb-4">
        <div class="w-full md:w-1/2">
            <label for="referrer_email" class="block text-gray-700 font-medium">Referrer Email</label>
            <input type="email" id="referrer_email" name="referrer_email" class="form-input-theme" placeholder="Enter referrer email">
        </div>
        <div class="w-full md:w-1/2">
            <label for="referrer_mobile_no" class="block text-gray-700 font-medium">Referrer Mobile No</label>
            <div class="flex items-center gap-2">
                <select id="referrer_country_code" name="referrer_country_code" class="form-input-theme w-20">
                    <option value="+91" selected>+91</option>
                    <option value="+1">+1</option>
                    <option value="+44">+44</option>
                    <option value="+61">+61</option>
                    <!-- Add more as needed -->
                </select>
                <input type="text" id="referrer_mobile_number" name="referrer_mobile_number" class="form-input-theme flex-1" placeholder="Enter referrer mobile number" maxlength="15" inputmode="numeric">
                <input type="hidden" id="referrer_mobile_no" name="referrer_mobile_no">
            </div>
        </div>
    </div>
    <div class="flex gap-8 mb-4">
        <div class="w-full md:w-1/2">
            <label for="remarks" class="block text-gray-700 font-medium">Remarks</label>
            <textarea id="remarks" name="remarks" class="form-input-theme" rows="3" placeholder="Add any additional notes or context"></textarea>
        </div>
    </div>

    <div class="flex items-center justify-end gap-4 mt-10 mb-4">
        <button onclick="history.back()" class="bg-white border border-[#7A2B26] hover:bg-[#f3eae9] hover:border-[#5e1f1b] transition-colors duration-200 text-[#5e1f1b] font-medium px-4 py-2 rounded">
            Cancel
        </button>
        <button type="submit" id="submitBtn" onclick="createUser(event)" class="flex items-center gap-2 justify-center bg-gradient-to-r from-[#BF360C] to-[#6D4C41] hover:from-[#943732] hover:to-[#4D322D] transition-colors duration-200 text-white font-medium px-4 py-2 rounded">
            <svg id="spinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
            </svg>
            <span id="submitText">Create Account</span>
        </button>

    </div>
</form>
@endsection
<style>
    .form-input-theme {
        width: 100%;
        border: none;
        border-bottom: 1px solid #9ca3af;
        border-radius: 0;
        padding: 0.5rem 0.75rem;
        margin-top: 0.25rem;
        background-color: #F5F5F5;
        color: #000000;
        transition: background-color 0.3s, border-color 0.3s;
    }

    /* Dark mode */
    @media (prefers-color-scheme: dark) {
        .form-input-theme {
            background-color: #2E1B1A;
            color: #ffffff;
        }
    }

    /* Focus state */
    .form-input-theme:focus {
        outline: none;
        border-bottom-color: #7A2B26;
        box-shadow: none;
    }

    /* When input has value */
    .form-input-theme:not(:placeholder-shown) {
        background-color: #EDE7E3;
    }

    .was-validated .form-input-theme:required:invalid {
        background-color: #fdecea !important;
        border-bottom-color: #f44336 !important;
    }

    .was-validated .form-input-theme:required:invalid::placeholder {
        color: #f44336 !important;
    }
</style>
<script>
    function createUser(e) {
        const form = document.getElementById('userForm');

        // Trigger validation
        if (!form.checkValidity()) {
            e.preventDefault(); // Stop submission
            form.classList.add('was-validated'); // Add class to trigger red input styles

            // Optional: Scroll to first invalid field
            const firstInvalid = form.querySelector(':invalid');
            if (firstInvalid) firstInvalid.focus();

            return false;
        }

        const code = document.getElementById('country_code').value;
        const mobile = document.getElementById('mobile_number').value.trim();
        document.getElementById('mobile_no').value = `${code}${mobile}`;

        const referrercode = document.getElementById('referrer_country_code').value;
        const referrermobile = document.getElementById('referrer_mobile_number').value.trim();
        document.getElementById('referrer_mobile_no').value = `${referrercode}${referrermobile}`;

        // Disable button and show loader
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        spinner.classList.remove('hidden');
        submitText.textContent = "Creating...";

        form.submit();
    }

    function togglePassword() {
        const input = document.getElementById("password");
        const isPassword = input.type === "password";
        input.type = isPassword ? "text" : "password";
        document.getElementById("eye-open").classList.toggle("hidden", isPassword);
        document.getElementById("eye-close").classList.toggle("hidden", !isPassword);
    }

    function toggleExclusive(clicked) {
        const checkboxes = ['is_whatsapp', 'is_onesignal'];
        checkboxes.forEach(id => {
            if (id !== clicked.id) {
                document.getElementById(id).checked = false;
            }
        });
    }
</script>