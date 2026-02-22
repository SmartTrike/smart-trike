@extends('layouts.app')

@section('content')
<div class="flex-1 h-full bg-gray-100 flex items-center p-4 justify-center">
    <div class="max-w-sm border border-gray-200 gap-6 rounded-2xl h-auto w-full bg-white shadow flex flex-col px-8 py-12">

        <h1 class="text-xl font-semibold text-gray-800 text-center">
            Create an Account
        </h1>

        <p class="text-center text-gray-500 text-sm">
            Choose account type to continue
        </p>

        <div class="grid grid-cols-2 gap-4 mt-4">

            <!-- Dispatcher Button -->
            <a href="{{ route('signup.dispatcher') }}"
               class="w-full border border-gray-300 hover:border-blue-500 hover:bg-blue-50 
                      text-gray-800 h-24 flex items-center justify-center hover:text-blue-600 font-semibold py-3 rounded-xl 
                      transition-all duration-150 text-center">
                Dispatcher
            </a>

            <!-- Driver Button -->
            <a href="{{ route('signup.driver') }}"
               class="w-full border border-gray-300 hover:border-green-500 hover:bg-green-50 
                      text-gray-800 h-24 flex items-center justify-center hover:text-green-600 font-semibold py-3 rounded-xl 
                      transition-all duration-150 text-center">
                Driver
            </a>
        </div>

        <div class="text-center mt-6">
            <!-- <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-700">
                Already have an account? Login
            </a> -->
            <p class="text-sm text-gray-700 font-medium">Already have an account? <a href="{{ route('login') }}" class="text-blue-600 underline ml-1">Login</a></p>
              
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
</script>
@endsection
