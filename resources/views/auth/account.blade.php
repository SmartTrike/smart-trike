@extends('layouts.app')
@section('content')
<div class="flex-1 h-full bg-gray-100 flex items-center p-4 justify-center">
    <div class="max-w-sm border border-gray-200 gap-4 rounded-2xl h-auto w-full bg-white shadow flex flex-col px-8 py-12">
        
        <div class="flex flex-row gap-2">
            <div>
                <img src="{{ asset('logo.png') }}" width="50" height="50" alt="Logo" class="shadow-sm z-50 -left-3 rounded-full">
            </div>
            <div>
                <h1 class="text-xl text-gray-800 font-semibold">Account Created Successfully!</h1>
                <p class="text-sm text-gray-600">Your account has been successfully created. You can now log in using the account number provided below. If needed, you can change your password later in your profile.</p>
            </div>
        </div>

        <div class="flex flex-col gap-4 mt-6">
            <!-- Display Account Number -->
            <div class="flex flex-col gap-1">
                <label class="text-sm font-semibold text-gray-700">Account Number</label>
                <input type="text" value="{{ $accountNumber }}" disabled class="w-full rounded border border-gray-300 bg-gray-100">
            </div>
            <p class="text-sm text-gray-600 mt-2">You can use this account number as both your Account ID and Password for login.</p>

            <!-- Button to Login -->
            <div class="mt-6 text-center">
                <a href="/login" class="py-2 px-4 rounded bg-[#0053A1] hover:bg-[#0053A1]/90 transition duration-200 font-bold text-white">Go to Login</a>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
// You can add any JavaScript if needed for dynamic content here.
</script>
@endsection
