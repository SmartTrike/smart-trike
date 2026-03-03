@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-white md:bg-gray-50/30 p-4 lg:p-10">
    <div class="max-w-4xl mx-auto my-auto">
        <header class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Welcome, {{ auth()->user()->username }}</h1>
            <p class="text-gray-500 mt-1 text-lg">Here is your profile details.</p>
        </header>

        <!-- Profile Information Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Driver Profile Section -->
            <section class="space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <h2 class="text-sm font-bold uppercase tracking-widest text-gray-400">Driver Profile</h2>
                    <x-heroicon-o-user class="w-4 h-4 text-gray-400" />
                </div>

                <!-- Display Profile Picture -->
                <div class="space-y-4">
                    <div class="flex flex-col md:flex-row items-center gap-8 p-6 bg-white rounded-xl border border-gray-100 ">
                        <div class="relative w-32 h-32 shrink-0 group">
                            <div class="w-full h-full rounded-full overflow-hidden bg-gray-100 border-4 border-white ">
                                @if ($driverInfo->profile_photo)
                                <img id="preview-image" src="{{ asset('storage/' . $driverInfo->profile_photo) }}" alt="Profile Photo" class="w-full h-full object-cover">
                                @else
                                <div id="placeholder-icon" class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <img id="preview-image" class="hidden w-full h-full object-cover">
                                @endif
                            </div>
                        </div>

                        <div class="flex-1">
                            <form action="{{ route('driver.updatePhoto') }}" method="POST" enctype="multipart/form-data" class="flex flex-col space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Update Profile Photo</label>
                                    <input
                                        type="file"
                                        name="profile_photo"
                                        id="profile_photo"
                                        accept="image/*"
                                        onchange="previewFile()"
                                        class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100 cursor-pointer">
                                </div>

                                @error('profile_photo')
                                <div class="mt-2 text-sm text-red-600 font-medium italic">
                                    {{ $message }}
                                </div>
                                @enderror

                                @if(session('success'))
                                <div class="mt-2 text-sm text-green-600 font-medium">
                                    {{ session('success') }}
                                </div>
                                @endif
                                <div id="action-buttons" class="hidden flex gap-2">
                                    <button type="submit" class="px-6 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition ">
                                        Confirm Upload
                                    </button>
                                    <button type="button" onclick="window.location.reload()" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-200">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase">Name</label>
                        <p class="text-gray-900 font-semibold text-lg">{{ $driverInfo->first_name }} {{ $driverInfo->last_name }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase">License No.</label>
                            <p class="text-gray-700 font-medium">{{ $driverInfo->license_number ?? '—' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase">License Expiry</label>
                            <p class="text-gray-700 font-medium">{{ $driverInfo->license_expiry_date ? \Carbon\Carbon::parse($driverInfo->license_expiry_date)->format('M d, Y') : '—' }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Vehicle Information Section -->
            <section class="space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <h2 class="text-sm font-bold uppercase tracking-widest text-gray-400">Vehicle Details</h2>
                    <x-heroicon-o-truck class="w-4 h-4 text-gray-400" />
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 text-sm">Plate Number</span>
                        <span class="font-mono font-bold text-gray-900 bg-white px-2 py-1 border border-gray-200 rounded shadow-sm">{{ $driverInfo->plate_number ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">MTOP Number</span>
                        <span class="font-semibold text-gray-900">{{ $driverInfo->mtop_number ?? 'N/A' }}</span>
                    </div>
                </div>
            </section>

        </div>

        <div class=" py-10 space-y-8">

            <div class="bg-white shadow rounded-lg ">
                <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-2">Driver Profile Information</h3>

                <form action="{{ route('driver.profileUpdate') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase">First Name</label>
                                <input type="text" name="first_name" value="{{ old('first_name', $driverInfo->first_name) }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase">Middle Name</label>
                                <input type="text" name="middle_name" value="{{ old('middle_name', $driverInfo->middle_name) }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase">Last Name</label>
                                <input type="text" name="last_name" value="{{ old('last_name', $driverInfo->last_name) }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase">Suffix</label>
                                <input type="text" name="suffix" value="{{ old('suffix', $driverInfo->suffix) }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="e.g. Jr.">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase">Contact Number</label>
                            <input type="text" name="contact_number" value="{{ old('contact_number', $driverInfo->contact_number) }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase">Birthdate</label>
                            <input type="date" name="birthdate" value="{{ old('birthdate', $driverInfo->birthdate) }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-500 uppercase">Address</label>
                            <input type="text" name="address" value="{{ old('address', $driverInfo->address) }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="md:col-span-2 mt-4">
                            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider">License & Vehicle Details</h4>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase">License Number</label>
                            <input type="text" name="license_number" value="{{ old('license_number', $driverInfo->license_number) }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase">Plate Number</label>
                            <input type="text" name="plate_number" value="{{ old('plate_number', $driverInfo->plate_number) }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase">Tricycle Body #</label>
                            <input type="text" name="tricycle_body_number" value="{{ old('tricycle_body_number', $driverInfo->tricycle_body_number) }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase">Model/Year</label>
                            <input type="text" name="model" value="{{ old('model', $driverInfo->model) }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-8 py-2 rounded-md font-semibold hover:bg-blue-700 transition">Save Profile Changes</button>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow rounded-lg  ">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Change Password</h3>
                <p class="text-sm text-gray-500 mb-6">Ensure your account is using a long, random password to stay secure.</p>

                <form action="{{ route('driver.passwordUpdate') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase">Current Password</label>
                            <input type="password" name="current_password" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase">New Password</label>
                            <input type="password" name="password" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-gray-800 text-white px-8 py-2 rounded-md font-semibold hover:bg-black transition">Update Password</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

<script>
    function previewFile() {
        const file = document.getElementById('profile_photo').files[0];
        const preview = document.getElementById('preview-image');
        const placeholder = document.getElementById('placeholder-icon');
        const actionButtons = document.getElementById('action-buttons');

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                // Set the image source to the file data
                preview.src = e.target.result;
                preview.classList.remove('hidden');

                // Hide placeholder if it exists
                if (placeholder) placeholder.classList.add('hidden');

                // Show the "Confirm/Cancel" buttons
                actionButtons.classList.remove('hidden');
            }

            reader.readAsDataURL(file);
        }
    }
</script>