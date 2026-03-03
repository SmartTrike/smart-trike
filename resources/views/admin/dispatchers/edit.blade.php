@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
    <div class="max-w-5xl mx-auto">
        
        <nav class="mb-6">
            <a href="{{ route('admin.dispatchers.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
                <x-heroicon-o-chevron-left class="w-4 h-4 mr-1" />
                Back to Dispatchers
            </a>
        </nav>

        <header class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Edit Dispatcher Profile</h1>
            <p class="text-gray-500 mt-1">Managing account for: <span class="font-bold text-gray-900">{{ $dispatcherInformation->user->username }}</span></p>
        </header>

        <div class="space-y-8">
            
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-8">
                <form action="" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-10">
                        <section>
                            <div class="flex items-center justify-between border-b border-gray-100 pb-2 mb-6">
                                <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Account Credentials</h2>
                                <x-heroicon-o-lock-closed class="w-4 h-4 text-gray-400" />
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Username</label>
                                    <input type="text" name="username" value="{{ old('username', $dispatcherInformation->user->username) }}" 
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 outline-none text-sm font-medium">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Email Address</label>
                                    <input type="email" name="email" value="{{ old('email', $dispatcherInformation->user->email) }}" 
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 outline-none text-sm font-medium">
                                </div>
                            </div>
                        </section>

                        <section>
                            <div class="flex items-center justify-between border-b border-gray-100 pb-2 mb-6">
                                <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Personal Details</h2>
                                <x-heroicon-o-user class="w-4 h-4 text-gray-400" />
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">First Name</label>
                                    <input type="text" name="first_name" value="{{ old('first_name', $dispatcherInformation->first_name) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Last Name</label>
                                    <input type="text" name="last_name" value="{{ old('last_name', $dispatcherInformation->last_name) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Contact Number</label>
                                    <input type="text" name="contact_number" value="{{ old('contact_number', $dispatcherInformation->contact_number) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm">
                                </div>
                               
                                <div class="md:col-span-4">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Address</label>
                                    <input type="text" name="address" value="{{ old('address', $dispatcherInformation->address) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm">
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="mt-10 pt-6 border-t border-gray-50 flex justify-end">
                        <button type="submit" class="bg-gray-900 text-white px-10 py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-black transition shadow-lg">
                            Save Profile Changes
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-8">
                <div class="flex items-center justify-between border-b border-gray-100 pb-2 mb-6">
                    <h2 class="text-xs font-bold uppercase tracking-widest text-red-500">Reset Password</h2>
                    <x-heroicon-o-shield-check class="w-4 h-4 text-red-500" />
                </div>
                <p class="text-sm text-gray-500 mb-6">As an admin, you can reset this dispatcher's password without knowing their current one.</p>

                <form action="" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">New Password</label>
                            <input type="password" name="password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-red-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-red-500 outline-none">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-red-500 text-white px-10 py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-red-600 transition shadow-md">
                            Force Update Password
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection