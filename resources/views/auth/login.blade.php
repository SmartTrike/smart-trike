@extends('layouts.app')
@section('content')
<div class="flex-1 h-full bg-gray-100 flex items-center p-4 justify-center">
    <div class="max-w-sm border border-gray-200 gap-4 rounded-2xl h-auto w-full bg-white shadow flex flex-col px-8 py-12">

        <div class="flex flex-row gap-2">
            <div>
                <img src="{{ asset('logo.png') }}" width="50" height="50" alt="Logo" class="shadow-sm z-50 -left-3 rounded-full">
            </div>
            <div>
                <h1 class="text-xl text-gray-800 font-semibold">Welcome back!</h1>
                <p class="text-sm text-gray-600">Please enter your account details</p>
            </div>
        </div>


        @if ($errors->has('credentials'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <div class="font-semibold text-sm">Oops! Something went wrong.</div>
            <div class="mt-2 text-sm">
                <p>{{ $errors->first('credentials') }}</p>
            </div>
        </div>
        @endif

        <form action="/login" class="flex flex-col gap-3 w-full mt-2 flex-1" method="post">
            @csrf
            <div class="flex flex-col gap-1">
                <label for="username" class="text-sm font-semibold text-gray-700">Username</label>
                <input type="text" name="username" id="username" class="w-full rounded border border-gray-300 @error('username') border-red-500 @enderror">
                @error('username')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-1">
                <label for="password" class="text-sm font-semibold text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="w-full rounded border border-gray-300 @error('password') border-red-500 @enderror">
                @error('password')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- <a href="http://" tabindex="-1" class="text-end text-blue-500 font-semibold hover:underline text-sm">Forgot Password?</a> -->
            <button type="submit" class="mt-auto py-1.5 rounded bg-[#0053A1] hover:bg-[#0053A1]/90 transition duration-200 font-bold text-white w-full">
                Login
            </button>
        </form>

        <div class="flex flex-row">
            <p class="text-sm text-gray-700 font-medium">Don't have an account? <a href="/signup" class="text-blue-600 underline ml-2">Create an Account</a></p>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    // Optional: You can add custom client-side validation or any other JS code
</script>
@endsection