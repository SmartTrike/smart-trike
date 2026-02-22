@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50/50 p-6 lg:p-10">
    
    <div class=" mx-auto">
        <header class="flex flex-col mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Add New Dispatcher</h1>
            <p class="text-sm text-gray-500">Fill in the details below to create a new dispatcher account.</p>
        </header>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.dispatchers.store') }}" method="POST" class="p-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    
                    <div class="md:col-span-2">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-400 mb-2">Personal Details</h3>
                        <hr class="border-gray-100 mb-2">
                    </div>

                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" id="first_name" name="first_name" 
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-200 outline-none" 
                            placeholder="John" required>
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" id="last_name" name="last_name" 
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-200 outline-none" 
                            placeholder="Doe" required>
                    </div>

                    <div>
                        <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                        <input type="text" id="contact_number" name="contact_number" 
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-200 outline-none" 
                            placeholder="+63 9123456789">
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <input type="text" id="address" name="address" 
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-200 outline-none" 
                            placeholder="123 Street, City">
                    </div>

                    <div class="md:col-span-2 mt-4">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-400 mb-2">Account Security</h3>
                        <hr class="border-gray-100 mb-2">
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" id="username" name="username" 
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-200 outline-none" 
                            required>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" id="email" name="email" 
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-200 outline-none" 
                            placeholder="example@email.com">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" id="password" name="password" 
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-200 outline-none" 
                            required>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-200 outline-none" 
                            required>
                    </div>

                </div>

                <div class="mt-10 flex items-center justify-end space-x-4 border-t border-gray-100 pt-6">
                    <a href="{{ route('admin.dispatchers.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-800 transition">
                        Cancel
                    </a>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-500/30 transition duration-200">
                        Create Dispatcher
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection