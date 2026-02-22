@extends('layouts.app')

@section('content')
<div class="flex-1 bg-gray-100 flex items-center p-4 justify-center">
    <div class="max-w-4xl gap-6 h-full w-full bg-white rounded-2xl shadow-2xl flex flex-col px-8 py-12">
        <form action="{{ route('signup.driver') }}" class="space-y-10" method="POST">
            @csrf
            <div class="w-full relative h-10 rounded-md bg-[#0053A1] flex items-center">
                <img src="{{ asset('logo.png') }}" width="50" height="50" alt="Logo" class="absolute shadow-smz-50 -left-3 rounded-full">
                <span class="ml-10 font-bold text-white text-sm">Driver Signup</span>
            </div>

            <!-- Driver Personal Information Section -->
            <div class="space-y-6">
                <h2 class="text-slate-900 text-2xl font-bold leading-tight tracking-[-0.015em] border-b border-slate-200 pb-3">Driver Personal Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <label class="flex flex-col">
                        <p class="text-slate-800 text-base font-medium leading-normal pb-2">First Name</p>
                        <input class="form-input flex w-full border border-gray-200 rounded-md p-2" required name="first_name" type="text" value="{{ old('first_name') }}" required placeholder="Enter first name" />
                    </label>
                    <label class="flex flex-col">
                        <p class="text-slate-800 text-base font-medium leading-normal pb-2">Middle Name</p>
                        <input class="form-input flex w-full border border-gray-200 rounded-md p-2" name="middle_name" type="text" value="{{ old('middle_name') }}" placeholder="Enter middle name" />
                    </label>
                    <label class="flex flex-col">
                        <p class="text-slate-800 text-base font-medium leading-normal pb-2">Last Name</p>
                        <input class="form-input flex w-full border border-gray-200 rounded-md p-2" required name="last_name" type="text" value="{{ old('last_name') }}" required placeholder="Enter last name" />
                    </label>
                    <label class="flex flex-col">
                        <p class="text-slate-800 text-base font-medium leading-normal pb-2">Suffix</p>
                        <input class="form-input flex w-full border border-gray-200 rounded-md p-2" name="suffix" type="text" value="{{ old('suffix') }}" placeholder="e.g. Jr." />
                    </label>
                    <label class="flex flex-col">
                        <p class="text-slate-800 text-base font-medium leading-normal pb-2">Contact Number</p>
                        <input class="form-input flex w-full border border-gray-200 rounded-md p-2" required name="contact_number" type="tel" value="{{ old('contact_number') }}" placeholder="e.g. 09123456789" />
                    </label>
                    <label class="flex flex-col">
                        <p class="text-slate-800 text-base font-medium leading-normal pb-2">Birthdate</p>
                        <input class="form-input flex w-full border border-gray-200 rounded-md p-2" required name="birthdate" type="date" value="{{ old('birthdate') }}" />
                    </label>
                    <label class="flex flex-col">
                        <p class="text-slate-800 text-base font-medium leading-normal pb-2">License Number</p>
                        <input class="form-input flex w-full border border-gray-200 rounded-md p-2" required name="license_number" type="text" value="{{ old('license_number') }}" placeholder="Enter license number" />
                    </label>
                </div>
            </div>

            <!-- Operator Information Section -->
            <div class="space-y-6">
                <h2 class="text-slate-900 text-2xl font-bold leading-tight tracking-[-0.015em] border-b border-slate-200 pb-3">Operator Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <label class="flex flex-col">
                        <p class="text-slate-800 text-base font-medium leading-normal pb-2">Operator Name</p>
                        <input class="form-input flex w-full border border-gray-200 rounded-md p-2" required name="operator_name" type="text" value="{{ old('operator_name') }}" placeholder="Enter operator's name" />
                    </label>
                    <label class="flex flex-col">
                        <p class="text-slate-800 text-base font-medium leading-normal pb-2">Operator Contact</p>
                        <input class="form-input flex w-full border border-gray-200 rounded-md p-2" required name="operator_contact" type="tel" value="{{ old('operator_contact') }}" placeholder="Enter operator's contact" />
                    </label>
                </div>
            </div>

            <!-- Tricycle Information Section -->
            <div class="space-y-6">
                <h2 class="text-slate-900 text-2xl font-bold leading-tight tracking-[-0.015em] border-b border-slate-200 pb-3">Tricycle Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <label class="flex flex-col">
                        <p class="text-slate-800 text-base font-medium leading-normal pb-2">MTOP Number</p>
                        <input class="form-input flex w-full border border-gray-200 rounded-md p-2" required name="mtop_number" type="text" value="{{ old('mtop_number') }}" />
                    </label>
                    <label class="flex flex-col">
                        <p class="text-slate-800 text-base font-medium leading-normal pb-2">Plate Number</p>
                        <input class="form-input flex w-full border border-gray-200 rounded-md p-2" required name="plate_number" type="text" value="{{ old('plate_number') }}" />
                    </label>
                </div>
            </div>

            <!-- New Username, Password, Confirm Password Fields -->
            <div class="space-y-6">
                <h2 class="text-slate-900 text-2xl font-bold leading-tight tracking-[-0.015em] border-b border-slate-200 pb-3">Account Information</h2>
                <div class="grid grid-cols-1 gap-6">
                    <!-- Username -->
                    <label class="flex flex-col">
                        <p class="text-slate-800 text-base font-medium leading-normal pb-2">Username</p>
                        <input class="form-input flex w-full border border-gray-200 rounded-md p-2" required name="username" type="text" value="{{ old('username') }}" placeholder="Enter your username" />
                    </label>

                    <!-- Password -->
                    <label class="flex flex-col">
                        <p class="text-slate-800 text-base font-medium leading-normal pb-2">Password</p>
                        <input class="form-input flex w-full border border-gray-200 rounded-md p-2" required name="password" type="password" placeholder="Enter your password" />
                    </label>

                    <!-- Confirm Password -->
                    <label class="flex flex-col">
                        <p class="text-slate-800 text-base font-medium leading-normal pb-2">Confirm Password</p>
                        <input class="form-input flex w-full border border-gray-200 rounded-md p-2" required name="password_confirmation" type="password" placeholder="Confirm your password" />
                    </label>
                </div>
            </div>

            <!-- Form Submission -->
            <div class="flex flex-col items-center gap-4 pt-4">
                <button class="w-full flex bg-[#0053A1] hover:bg-[#0053A1]/90 cursor-pointer items-center justify-center overflow-hidden rounded h-12 px-6 bg-primary text-white text-base font-bold leading-normal tracking-[0.015em] focus:outline-none" type="submit">
                    <span class="truncate">Register Driver</span>
                </button>

                <div class="text-center mt-2">
                    <p class="text-sm text-gray-700 font-medium">Already have an account? <a href="{{ route('login') }}" class="text-blue-600 underline ml-1">Login</a></p>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
</script>
@endsection
