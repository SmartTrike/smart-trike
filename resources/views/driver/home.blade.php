@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-white  md:bg-gray-50/30  p-4 lg:p-10">
    <div class="max-w-4xl mx-auto my-auto ">
        
        <header class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Welcome, {{ auth()->user()->username }}</h1>
            <p class="text-gray-500 mt-1 text-lg">Here is your operation status for today.</p>
        </header>

        <div class="mb-10">
            @if($queuePosition === null)
                <div class="bg-amber-50 border border-amber-100 rounded-2xl p-6 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-amber-100 rounded-full mr-4">
                            <x-heroicon-o-exclamation-triangle class="w-6 h-6 text-amber-600" />
                        </div>
                        <div>
                            <h3 class="text-amber-900 font-bold text-lg">Not Checked In</h3>
                            <p class="text-amber-700 text-sm">Check in to join the tricycle queue.</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('driver.checkin') }}" class="w-full md:w-auto">
                        @csrf
                        <button type="submit" class="w-full px-8 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-black transition-all active:scale-95 shadow-lg shadow-gray-200">
                            Check In Now
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-green-50 border border-green-100 rounded-2xl p-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="relative flex h-3 w-3 mr-4">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                        </div>
                        <div>
                            <h3 class="text-green-900 font-bold text-lg">Currently Active</h3>
                            <p class="text-green-700 text-sm">You are in the dispatching queue.</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-bold text-green-600 uppercase tracking-widest block">Queue Position</span>
                        @if ($queuePosition !== null)
                            <span class="text-4xl font-black text-green-700">#{{ $queuePosition }}</span>
                        @else
                            <span class="text-4xl font-black text-green-700">N/A</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <section class="space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <h2 class="text-sm font-bold uppercase tracking-widest text-gray-400">driverInfo Profile</h2>
                    <x-heroicon-o-user class="w-4 h-4 text-gray-400" />
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase"> Name</label>
                        <p class="text-gray-900 font-semibold text-lg">{{ $driverInfo->first_name }} {{ $driverInfo->last_name }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase">License No.</label>
                            <p class="text-gray-700 font-medium">{{ $driverInfo->license_number ?? '—' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase">Expiry</label>
                            <p class="text-gray-700 font-medium">{{ $driverInfo->license_expiry_date ? \Carbon\Carbon::parse($driverInfo->license_expiry_date)->format('M d, Y') : '—' }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <h2 class="text-sm font-bold uppercase tracking-widest text-gray-400">Vehicle Details</h2>
                    <x-heroicon-o-truck class="w-4 h-4 text-gray-400" />
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 text-sm">Plate Number</span>
                        <span class="font-mono font-bold text-gray-900 bg-white px-2 py-1 border border-gray-200 rounded shadow-sm">{{ $driverInfo->plate_number ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">MTOP Number</span>
                        <span class="font-semibold text-gray-900">{{ $driverInfo->mtop_number ?? 'N/A' }}</span>
                    </div>
                    <!-- <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Unit Model</span>
                        <span class="font-semibold text-gray-900">{{ $driverInfo->model }} ({{ $driverInfo->color }})</span>
                    </div> -->
                </div>
            </section>
        </div>

    </div>
</div>
@endsection
