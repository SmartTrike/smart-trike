@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-white md:bg-gray-50/30 p-4 lg:p-10 overflow-y-auto">
    <div class="w-full space-y-6">

        <!-- Header Section -->
        <header class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Welcome, {{ auth()->user()->username }}</h1>
            <p class="text-lg text-gray-500 mt-2">{{ now()->format('l, F j, Y \a\t g:i A') }}</p>
        </header>

        <!-- Dashboard Stats Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Active Drivers -->
            <div class="bg-white p-6 rounded-lg shadow-xs border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Drivers in Queue</h2>
                <p class="text-3xl text-blue-500 mt-2" id="activeDrivers">{{ $activeQueueCount }}</p>
                <p class="text-gray-500 text-sm mt-2">Total active drivers currently in queue.</p>
            </div>

            <!-- Pending Trips -->
            <div class="bg-white p-6 rounded-lg shadow-xs border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Active Trips</h2>
                <p class="text-3xl text-orange-500 mt-2" id="pendingTrips">{{ $onRideCount }}</p>
                <p class="text-gray-500 text-sm mt-2">Trips that are still on ride.</p>
            </div>

            <!-- Completed Trips -->
            <div class="bg-white p-6 rounded-lg shadow-xs border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Completed Trips</h2>
                <p class="text-3xl text-green-500 mt-2" id="completedTrips">{{$completedCount}}</p>
                <p class="text-gray-500 text-sm mt-2">Total trips completed today.</p>
            </div>

            <!-- Cancelled Trips -->
            <div class="bg-white p-6 rounded-lg shadow-xs border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Lost and Found</h2>
                <p class="text-3xl text-red-500 mt-2" id="lostAndFoundCount">{{$lostAndFoundCount}}</p>
                <p class="text-gray-500 text-sm mt-2">Total items reported.</p>
            </div>
        </div>

        <section class="mx-auto">
            @if($currentQueueDriver && $driverDetails)
            <div class="bg-white rounded-xl flex flex-col gap-4 shadow-sm border border-gray-200 overflow-hidden">
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
                                <span class="ml-2 text-lg">{{ $driverDetails->mtop_number }}</span>
                            </div>
                        </div>

                        <div class="bg-gray-50 border border-gray-100 rounded-lg p-3 text-center min-w-[120px]">
                            <p class="text-2xs uppercase text-gray-400 font-bold leading-none mb-1">Checked In</p>
                            <p class="text-xl font-mono font-semibold text-gray-700">
                                {{ $currentQueueDriver->created_at->format('h:i A') }}
                            </p>
                        </div>
                    </div>

                    <hr class="my-6 border-gray-100">

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">Plate Number</label>
                            <p class="text-gray-800 font-semibold">{{ $driverDetails->plate_number ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">License Expiration Date</label>
                            <p class="text-gray-800 font-semibold">{{ $driverDetails->license_expiry_date ? \Carbon\Carbon::parse($driverDetails->license_expiry_date)->format('M d, Y') : '—' }}</p>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">Contact</label>
                            <p class="text-gray-800 font-semibold">{{ $driverDetails->contact_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <button type="button"
                    onclick="openDispatchModal({{ $currentQueueDriver->driver_id }}, '{{ $driverDetails->first_name }} {{ $driverDetails->last_name }}')"
                    class="group relative w-full md:w-auto overflow-hidden bg-green-600 hover:bg-green-700 text-white px-10 py-4 rounded-xl text-xs font-black uppercase tracking-[0.2em] transition-all shadow-xl shadow-green-500/20 active:scale-95">

                    <span class="relative z-10 flex items-center justify-center gap-2">
                        Dispatch Now
                        <x-heroicon-s-paper-airplane class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                    </span>

                </button>
                @else
                <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl p-12 text-center">
                    <p class="text-gray-500 font-medium text-lg">The queue is currently empty.</p>
                </div>
                @endif
        </section>

        <!-- Ongoing Drivers Table Section -->
        <section class="bg-blue-50 rounded-md overflow-hidden mt-6">
            <div class="w-full bg-[#0054A1] rounded-md h-12 px-4 py-1.5 flex items-center ">
                <p class="font-bold text-white">On Ride</p>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50/50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Driver ID</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Status</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Dispatch Time</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Dispatch By</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($ongoingRides as $ongoing)
                            <tr class="hover:bg-gray-50/30 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg  flex items-center justify-center text-white text-xs font-black shadow-inner">
                                            <!-- {{ strtoupper(substr($ongoing->username, 0, 2)) }} -->


                                            <div id="placeholder-icon" class="w-full rounded-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>

                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900 ">{{ $ongoing->driver->username }}</div>
                                            <div class="text-2xs text-gray-400 uppercase tracking-tighter">ID: #{{ $ongoing->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600 font-medium ">{{ $ongoing->status=== 'ongoing'? 'On Going': 'N/A' }}</div>
                                </td>



                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700 font-medium">{{ $ongoing->dispatch_at->format('M d, Y')   }}, {{ $ongoing->dispatch_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700 font-medium">{{ $ongoing->dispatcher->username }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="" class="text-xs font-black uppercase tracking-widest text-blue-600 hover:text-blue-800 transition-colors">
                                            View
                                        </a>
                                        <span class="text-gray-200">|</span>

                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <x-heroicon-o-users class="w-12 h-12 text-gray-200 mb-4" />
                                        <p class="text-gray-500 font-medium">No ongoing rides found.</p>
                                        <p class="text-xs text-gray-400 mt-1">Try adjusting your search filters.</p>
                                    </div>
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

        <section class="bg-white p-6 rounded-md shadow-xs border border-gray-200 mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Tricycle Routes in Bayambang Ligue</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12355.505685726233!2d120.41852693241148!3d15.824830607113638!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33914f27477d6d3f%3A0xd1241caa3394b6d9!2sLigue%2C%20Bayambang%2C%20Pangasinan!5e1!3m2!1sen!2sph!4v1771696502669!5m2!1sen!2sph" class="w-full h-96" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </section>

    </div>
</div>
@endsection