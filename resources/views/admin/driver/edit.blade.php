@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
    <div class="max-w-5xl mx-auto">
        
        <nav class="mb-6">
            <a href="{{ route('admin.driver.list') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
                <x-heroicon-o-chevron-left class="w-4 h-4 mr-1" />
                Back to Driver List
            </a>
        </nav>

        <header class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Edit Driver: {{ $driverInfo->first_name }}</h1>
            <p class="text-gray-500 mt-1">Managing account credentials and vehicle details.</p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm text-center">
                    <div class="relative w-32 h-32 mx-auto mb-4">
                        <div class="w-full h-full rounded-full overflow-hidden bg-gray-100 border-4 border-white shadow-sm">
                            @if ($driverInfo->profile_photo)
                                <img src="{{ asset('storage/' . $driverInfo->profile_photo) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-50">
                                    <x-heroicon-s-user class="w-16 h-16" />
                                </div>
                            @endif
                        </div>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900">{{ $driverInfo->first_name }} {{ $driverInfo->last_name }}</h2>
                    <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mt-1"> Driver</p>
                </div>

                <div class="bg-gray-900 rounded-2xl p-6 text-white shadow-lg">
                    <h3 class="text-2xs font-black uppercase tracking-[0.2em] text-gray-400 mb-4">Vehicle Assignment</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-400">Plate Number</span>
                            <span class="font-mono font-bold">{{ $driverInfo->plate_number ?? 'NONE' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-400">Body Number</span>
                            <span class="font-bold">{{ $driverInfo->tricycle_body_number ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-8 w-full">
                
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-8">
                    <form action="{{ route('admin.drivers.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-8">
                            <section>
                                <div class="flex items-center gap-2 border-b border-gray-50 pb-2 mb-6">
                                    <h3 class="text-xs font-black uppercase tracking-widest text-gray-400">Account Access</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-2xs font-bold text-gray-400 uppercase mb-2">Username</label>
                                        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-gray-900 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-2xs font-bold text-gray-400 uppercase mb-2">Email</label>
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-gray-900 outline-none">
                                    </div>
                                </div>
                            </section>

                            <section>
                                <div class="flex items-center gap-2 border-b border-gray-50 pb-2 mb-6">
                                    <h3 class="text-xs font-black uppercase tracking-widest text-gray-400">Driver & Vehicle Details</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-2xs font-bold text-gray-400 uppercase mb-2">First Name</label>
                                        <input type="text" name="first_name" value="{{ old('first_name', $driverInfo->first_name) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-2xs font-bold text-gray-400 uppercase mb-2">Last Name</label>
                                        <input type="text" name="last_name" value="{{ old('last_name', $driverInfo->last_name) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-2xs font-bold text-gray-400 uppercase mb-2">License Expiration Date</label>
                                        <input type="date" name="license_expiry_date" value="{{ old('license_expiry_date', $driverInfo->license_expiry_date) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-2xs font-bold text-gray-400 uppercase mb-2">Plate #</label>
                                        <input type="text" name="plate_number" value="{{ old('plate_number', $driverInfo->plate_number) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-mono uppercase">
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="mt-10 flex justify-end">
                            <button type="submit" class="bg-gray-900 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-black transition shadow-lg">
                                Save All Changes
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white border w-full  border-gray-100 rounded-2xl shadow-sm p-8">
                    <h3 class="text-xs font-black uppercase tracking-widest text-red-500 mb-6 border-b border-gray-50 pb-2">Administrative Password Reset</h3>
                    <form action="{{ route('admin.drivers.updatePassword', $user->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-2xs font-bold text-gray-400 uppercase mb-2">New Password</label>
                                <input type="password" name="password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-red-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-2xs font-bold text-gray-400 uppercase mb-2">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-red-500 outline-none">
                            </div>
                        </div>
                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="bg-red-500 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-red-600 transition shadow-md">
                                Force Password Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection