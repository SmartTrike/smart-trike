@extends('layouts.dashboard')

@section('content')
    <div class="min-h-screen bg-white md:bg-gray-50/30 p-4 lg:p-10">
        <div class="max-w-4xl mx-auto">
            <header class="mb-10">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Dispatcher Profile</h1>
                <p class="text-gray-500 mt-1 text-lg">Manage your personal information and account security.</p>
            </header>

            {{-- Alert Messages --}}
            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl bg-green-50 text-green-700 border border-green-100 flex items-center gap-3">
                    <x-tabler-check class="w-5 h-5" />
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700">
                    <ul class="text-sm list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-8">
                <section class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <div class="relative w-32 h-32 shrink-0">
                            <div
                                class="w-full h-full rounded-2xl overflow-hidden bg-indigo-50 border-4 border-white shadow-md">
                                @if ($dispatcherInfo->profile_photo)
                                    <x-cloudinary::image public-id="{{ $dispatcherInfo->profile_photo }}"
                                        alt="Profile Photo" class="w-full h-full object-cover" />
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-indigo-300">
                                        <x-tabler-user-cog class="w-16 h-16" />
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex-1 text-center md:text-left">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $dispatcherInfo->first_name }}
                                {{ $dispatcherInfo->last_name }}</h2>
                            <p class="text-indigo-600 font-semibold uppercase tracking-widest text-xs mt-1"> Dispatcher</p>
                            <div class="mt-4 flex flex-wrap justify-center md:justify-start gap-4">
                                <div class="flex items-center gap-2 text-gray-500 text-sm">
                                    <x-tabler-mail class="w-4 h-4" />
                                    {{ auth()->user()->email }}
                                </div>
                                <div class="flex items-center gap-2 text-gray-500 text-sm">
                                    <x-tabler-phone class="w-4 h-4" />
                                    {{ $dispatcherInfo->contact_number ?? 'No contact added' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-50">
                        <h3 class="text-lg font-bold text-gray-800">Edit Personal Information</h3>
                    </div>

                    <form action="{{ route('dispatcher.profile.update') }}" method="POST" class="p-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">First
                                    Name</label>
                                <input type="text" name="first_name"
                                    value="{{ old('first_name', $dispatcherInfo->first_name) }}"
                                    class="mt-2 w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none p-3 border">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Last
                                    Name</label>
                                <input type="text" name="last_name"
                                    value="{{ old('last_name', $dispatcherInfo->last_name) }}"
                                    class="mt-2 w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none p-3 border">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Email
                                    Address</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                    class="mt-2 w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none p-3 border">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Contact
                                    Number</label>
                                <input type="text" name="contact_number"
                                    value="{{ old('contact_number', $dispatcherInfo->contact_number) }}"
                                    class="mt-2 w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none p-3 border">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Home
                                    Address</label>
                                <input type="text" name="address" value="{{ old('address', $dispatcherInfo->address) }}"
                                    class="mt-2 w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none p-3 border">
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit"
                                class="bg-indigo-600 text-white px-10 py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                                Save Profile Changes
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden mb-10">
                    <div class="p-6 border-b border-gray-50">
                        <h3 class="text-lg font-bold text-gray-800">Security Settings</h3>
                        <p class="text-sm text-gray-500">Update your password regularly to keep your account safe.</p>
                    </div>

                    <form action="{{ route('dispatcher.password.update') }}" method="POST" class="p-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            {{-- CURRENT PASSWORD --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">
                                    Current Password
                                </label>
                                <input type="password" name="current_password"
                                    class="mt-2 w-full rounded-xl border p-3 
            @error('current_password') border-red-500 @else border-gray-200 @enderror">

                                @error('current_password')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- NEW PASSWORD --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">
                                    New Password
                                </label>
                                <input type="password" name="password"
                                    class="mt-2 w-full rounded-xl border p-3 
            @error('password') border-red-500 @else border-gray-200 @enderror">

                                @error('password')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- CONFIRM PASSWORD --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">
                                    Confirm New Password
                                </label>
                                <input type="password" name="password_confirmation"
                                    class="mt-2 w-full rounded-xl border p-3 
            @error('password') border-red-500 @else border-gray-200 @enderror">

                                @error('password')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit"
                                class="bg-gray-900 text-white px-10 py-3 rounded-xl font-bold hover:bg-black transition">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
