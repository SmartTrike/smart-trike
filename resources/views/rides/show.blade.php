@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
    <div class="max-w-4xl mx-auto">
        
        <nav class="mb-6">
            {{-- <a href="{{ route }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
                <x-heroicon-o-chevron-left class="w-4 h-4 mr-1" />
                Back to Active Rides
            </a> --}}
        </nav>

        <header class="mb-10 flex justify-between items-end">
            <div>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-widest rounded-full">Ongoing Ride</span>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight mt-2">Ride Details #{{ $ride->id }}</h1>
                <p class="text-gray-500">Dispatched at {{ $ride->dispatch_at->format('M d, Y - h:i A') }}</p>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-1 space-y-6">
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-2xs font-black uppercase tracking-widest text-gray-400 mb-4">Driver</h3>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gray-900 rounded-xl flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($ride->driver->username, 0, 2)) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $ride->driver->driverInfo->first_name }} {{ $ride->driver->driverInfo->last_name }}</p>
                            <p class="text-xs text-gray-500">Plate: {{ $ride->driver->driverInfo->plate_number }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-2xs font-black uppercase tracking-widest text-gray-400 mb-4">Dispatcher</h3>
                    <p class="text-sm font-bold text-gray-900">{{ $ride->dispatcher->username }}</p>
                    {{-- <p class="text-xs text-gray-500">Assigned during shift</p> --}}
                </div>
            </div>

            <div class="md:col-span-2 space-y-6">
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-8">
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <label class="block text-2xs font-bold text-gray-400 uppercase tracking-widest mb-1">Departure Time</label>
                            <p class="text-lg font-bold text-gray-900">{{ $ride->dispatch_at->format('h:i:s A') }}</p>
                        </div>
                        <div>
                            <label class="block text-2xs font-bold text-gray-400 uppercase tracking-widest mb-1">Current Status</label>
                            <p class="text-lg font-bold text-blue-600 uppercase italic">On Ride</p>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-2xs font-bold text-gray-400 uppercase tracking-widest mb-1">Passenger Count</label>
                            <p class="text-lg font-bold text-gray-900">{{ $ride->passenger_count ?? 'Not specified' }}</p>
                        </div>
                    </div>

                    <hr class="my-8 border-gray-50">

                    {{-- <form action="" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-2xs font-bold text-gray-400 uppercase mb-2">Arrival Remarks</label>
                            <textarea name="remarks" rows="2" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm" placeholder="Any issues during the ride?"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-green-600 text-white py-4 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-green-700 transition shadow-lg">
                            Confirm Return / Complete Ride
                        </button>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection