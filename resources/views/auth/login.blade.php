@extends('layouts.app')
@section('content')
<div class="flex-1 h-full bg-gray-100 flex items-center p-4 justify-center">
    <div class="max-w-sm border border-gray-200 gap-4 rounded-2xl h-auto w-full bg-white shadow flex flex-col px-8 py-12">
        
 
    <div class="flex flex-row gap-2">
        <div>
               <img src="{{ asset('logo.png') }}" width="50" height="50" alt="Logo" class=" shadow-sm z-50 -left-3 rounded-full">

        </div>
           <div>
             <h1 class="text-xl text-gray-800 font-semibold">Welcome back!</h1>
            <p class="text-sm text-gray-600">Please enter your account details</p>
           </div>
        </div>

        <form action="/login" class="flex flex-col gap-3 w-full mt-2 flex-1" method="post">
             @csrf
            <div class="flex flex-col gap-1">
                <label for="username" class="text-sm font-semibold text-gray-700">Username</label>
                <input type="text" name="username" id="username" class="w-full rounded border border-gray-300">
            </div>
            <div class="flex flex-col gap-1">
                <label for="password" class="text-sm font-semibold text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="w-full rounded border border-gray-300">
            </div>

            <a href="http://" tabindex="-1" class="text-end text-blue-500 font-semibold hover:underline text-sm">Forgot Password?</a>
            <button type="submit" class="mt-auto py-1.5 rounded bg-[#0053A1] hover:bg-[#0053A1]/90 transition duration-200 font-bold text-white w-full ">
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

</script>
@endsection