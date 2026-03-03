@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
    <div class="max-w-4xl mx-auto">
        
        <nav class="mb-6">
            <a href="{{ route('admin.dispatchers.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
                <x-heroicon-o-chevron-left class="w-4 h-4 mr-1" />
                Back to Dispatchers List
            </a>
        </nav>

        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Add New Dispatcher</h1>
            <p class="text-gray-500 mt-1">Set up a new account for terminal personnel.</p>
        </header>

        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
            <form action="{{ route('admin.dispatchers.store') }}" method="POST" class="p-8">
                @csrf

                <div class="space-y-10">
                    
                    <section>
                        <div class="flex items-center justify-between border-b border-gray-100 pb-2 mb-6">
                            <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Personal Information</h2>
                            <x-heroicon-o-user class="w-4 h-4 text-gray-400" />
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">First Name</label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all text-sm" 
                                    placeholder="Enter first name" required>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Last Name</label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all text-sm" 
                                    placeholder="Enter last name" required>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Contact Number</label>
                                <input type="text" name="contact_number" value="{{ old('contact_number') }}"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all text-sm" 
                                    placeholder="0912 345 6789">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Address</label>
                                <input type="text" name="address" value="{{ old('address') }}"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all text-sm" 
                                    placeholder="Street, Barangay, City">
                            </div>
                        </div>
                    </section>

                    <section>
                        <div class="flex items-center justify-between border-b border-gray-100 pb-2 mb-6">
                            <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400">Account Credentials</h2>
                            <x-heroicon-o-lock-closed class="w-4 h-4 text-gray-400" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-1">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Username</label>
                                <input type="text" name="username" value="{{ old('username') }}"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all text-sm" 
                                    required>
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Email Address</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all text-sm" 
                                    placeholder="required@email.com" required>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Password</label>
                                <input type="password" name="password" 
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all text-sm" 
                                    required>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Confirm Password</label>
                                <input type="password" name="password_confirmation" 
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all text-sm" 
                                    required>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="mt-12 pt-8 border-t border-gray-100 flex items-center justify-end gap-4">
                    <a href="{{ route('admin.dispatchers.index') }}" class="text-xs font-bold text-gray-400 uppercase tracking-widest hover:text-gray-900 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="bg-gray-900 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-black transition-all shadow-lg active:scale-95">
                        Create Dispatcher Account
                    </button>
                </div>
            </form>
        </div>

        @if ($errors->any())
            <div class="mt-6 p-4 bg-red-50 border border-red-100 rounded-2xl">
                <ul class="list-disc list-inside text-xs text-red-600 font-bold uppercase tracking-tight">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
</div>
@endsection