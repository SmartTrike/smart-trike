@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-white md:bg-gray-50/30 p-4 lg:p-10 overflow-y-auto">

    <!-- Header Section -->
    <header class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Add New Dispatcher</h1>
    </header>

    <!-- Dispatcher Form Section -->
    <section>
        <div class="bg-white p-6 rounded-lg shadow-xs border border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Create a new dispatcher</h2>

            <!-- Form to add new dispatcher -->
            <form action="{{ route('admin.dispatchers.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- First Name -->
                    <div class="mb-4">
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="w-full p-3 border border-gray-300 rounded-md" required>
                    </div>

                    <!-- Last Name -->
                    <div class="mb-4">
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="w-full p-3 border border-gray-300 rounded-md" required>
                    </div>

                    <!-- Contact Number -->
                    <div class="mb-4">
                        <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                        <input type="text" id="contact_number" name="contact_number" class="w-full p-3 border border-gray-300 rounded-md">
                    </div>

                    <!-- Address -->
                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" id="address" name="address" class="w-full p-3 border border-gray-300 rounded-md">
                    </div>

                    <!-- Status
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status" class="w-full p-3 border border-gray-300 rounded-md" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div> -->

                    <!-- Username -->
                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" id="username" name="username" class="w-full p-3 border border-gray-300 rounded-md" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" class="w-full p-3 border border-gray-300 rounded-md">
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" class="w-full p-3 border border-gray-300 rounded-md" required>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full p-3 border border-gray-300 rounded-md" required>
                    </div>

                </div>

                <!-- Submit Button -->
                <button type="submit" class="mt-6 bg-blue-500 text-white p-3 rounded-md hover:bg-blue-600">Add Dispatcher</button>
            </form>
        </div>
    </section>

</div>
@endsection