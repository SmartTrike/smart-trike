@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-white md:bg-gray-50/30 p-4 lg:p-10 overflow-y-auto">
    <div class="w-full space-y-6">
        <header class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Welcome, {{ auth()->user()->username }}</h1>
            <p class="text-lg text-gray-500 mt-2">{{ now()->format('l, F j, Y \a\t g:i A') }}</p>
        </header>

        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-xs border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">In Queue</h2>
                <p class="text-3xl text-blue-500 mt-2">{{ $activeQueueCount }}</p>
                <p class="text-gray-500 text-sm mt-2">Drivers waiting.</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-xs border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">On Ride</h2>
                <p class="text-3xl text-orange-500 mt-2">{{ $onRideCount }}</p>
                <p class="text-gray-500 text-sm mt-2">Currently active trips.</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-xs border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Completed</h2>
                <p class="text-3xl text-green-500 mt-2">{{$completedCount}}</p>
                <p class="text-gray-500 text-sm mt-2">Total trips today.</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-xs border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Lost & Found</h2>
                <p class="text-3xl text-red-500 mt-2">{{$lostAndFoundCount}}</p>
                <p class="text-gray-500 text-sm mt-2">Items reported.</p>
            </div>
        </div>

        @if($fare)
            <div class="mb-8 bg-indigo-900 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <span class="text-indigo-200 text-xs font-bold uppercase tracking-widest">Currently Active Rate</span>
                        <h2 class="text-2xl font-bold mt-1">{{ $fare->label }}</h2>
                    </div>
                    <div class="flex gap-8">
                        <div class="text-center">
                            <p class="text-indigo-300 text-xs uppercase font-semibold">Trip Fare</p>
                            <p class="text-xl font-bold">₱{{ number_format($fare->trip_fare, 2) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-indigo-300 text-xs uppercase font-semibold">Terminal</p>
                            <p class="text-xl font-bold">₱{{ number_format($fare->terminal_fare, 2) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-indigo-300 text-xs uppercase font-semibold">Hire</p>
                            <p class="text-xl font-bold">₱{{ number_format($fare->hire_fare, 2) }}</p>
                        </div>
                    </div>
                </div>
                {{-- Decorative background icon --}}
                <x-tabler-receipt-2 class="absolute -right-4 -bottom-4 w-32 h-32 text-white/10 rotate-12" />
            </div>

            @else 

            <div class="mb-6 bg-gray-100 border border-gray-200 rounded-2xl p-4 flex items-center gap-4">
            <div class="bg-gray-200 p-2 rounded-lg text-gray-500">
                <x-tabler-pennant-off class="w-5 h-5" />
            </div>
            <div>
                <p class="text-sm font-bold text-gray-700">Rates currently unavailable</p>
                <p class="text-xs text-gray-500">Please contact the administrator to initialize fare settings.</p>
            </div>
        </div>
        
            @endif
            

        <section class="mx-auto">
            @if($currentQueueDriver && $driverDetails)
            <div class="bg-white rounded-xl flex flex-col shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-blue-600 px-6 py-3 flex justify-between items-center">
                    <span class="text-white font-bold tracking-wider uppercase text-sm">First in Line</span>
                    <span class="bg-white text-blue-600 px-3 py-1 rounded-full text-xs font-black">QUEUE #1</span>
                </div>

                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="flex-1">
                            <h2 class="text-3xl font-extrabold text-gray-900 leading-tight">
                                {{ $driverDetails->first_name }} {{ $driverDetails->last_name }}
                            </h2>
                            <div class="flex items-center mt-1 text-blue-600 font-medium">
                                <span class="text-sm uppercase tracking-wide">MTOP No:</span>
                                <span class="ml-2 text-lg font-mono">{{ $driverDetails->mtop_number }}</span>
                            </div>
                        </div>

                        <div class="bg-gray-50 border border-gray-100 rounded-lg p-3 text-center min-w-[120px]">
                            <p class="text-2xs uppercase text-gray-400 font-bold leading-none mb-1">Check-in Time</p>
                            <p class="text-xl font-mono font-semibold text-gray-700">
                                {{ $currentQueueDriver->created_at->format('h:i A') }}
                            </p>
                        </div>
                    </div>

                    <hr class="my-6 border-gray-100">

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-4">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">Plate Number</label>
                            <p class="text-gray-800 font-semibold uppercase">{{ $driverDetails->plate_number ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">License Expiration Date</label>
                            <p class="text-gray-800 font-semibold uppercase">{{ $driverDetails->license_expiry_date ? \Carbon\Carbon::parse($driverDetails->license_expiry_date)->format('M d, Y') : '—' }}</p>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">Contact</label>
                            <p class="text-gray-800 font-semibold">{{ $driverDetails->contact_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <button type="button"
                    onclick="openDispatchModal({{ $currentQueueDriver->driver_id }}, '{{ $driverDetails->first_name }} {{ $driverDetails->last_name }}')"
                    class="group relative w-full overflow-hidden bg-green-600 hover:bg-green-700 text-white py-5 text-xs font-black uppercase tracking-[0.2em] transition-all shadow-xl active:scale-95">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        Dispatch This Driver
                        <x-heroicon-s-paper-airplane class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                    </span>
                </button>
            </div>
            @else
            <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl p-12 text-center">
                <p class="text-gray-500 font-medium text-lg">The queue is currently empty.</p>
            </div>
            @endif
        </section>

        <section class="mt-8">
            <div class="w-full bg-[#0054A1] rounded-t-xl h-12 px-6 flex items-center">
                <p class="font-bold text-white uppercase text-xs tracking-widest">Ongoing Trips</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-b-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50/50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-2xs font-black uppercase tracking-widest text-gray-400">Driver</th>
                                <th class="px-6 py-4 text-2xs font-black uppercase tracking-widest text-gray-400">Status</th>
                                <th class="px-6 py-4 text-2xs font-black uppercase tracking-widest text-gray-400">Dispatch Time</th>
                                <th class="px-6 py-4 text-2xs font-black uppercase tracking-widest text-gray-400">Dispatch By</th>
                                <th class="px-6 py-4 text-2xs font-black uppercase tracking-widest text-gray-400 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($ongoingRides as $ongoing)
                            <tr class="hover:bg-gray-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                            <x-heroicon-s-user class="w-4 h-4" />
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900">{{ $ongoing->driver->username }}</div>
                                            <div class="text-2xs text-gray-400 uppercase">Ride #{{ $ongoing->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-2xs font-black uppercase tracking-wider ">
                                        <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                        {{ $ongoing->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                    {{ $ongoing->dispatch_at->format('h:i A') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                    {{ $ongoing->dispatcher->username }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    {{-- <button onclick="openUpdateRideModal({{ $ongoing->id }}, '{{ $ongoing->driver->username }}', '{{ $ongoing->status }}')"
                                        class="text-2xs font-black uppercase tracking-widest text-blue-600 hover:text-blue-800 transition-colors  px-3 py-1 rounded-md ">
                                        Update Status
                                    </button> --}}
                                        <a href="{{ route('ongoing-rides.show', $ongoing->id) }}"     class="text-2xs font-black uppercase tracking-widest text-blue-600 hover:text-blue-800 transition-colors  px-3 py-1 rounded-md ">
                                      View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400 text-sm font-medium">
                                    No ongoing rides at the moment.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($ongoingRides->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $ongoingRides->links() }}
                </div>
                @endif
            </div>
        </section>


    </div>
</div>

@endsection