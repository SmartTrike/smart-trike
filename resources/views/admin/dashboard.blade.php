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
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
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
                <h2 class="text-xl font-semibold text-gray-800">Cancelled Trips</h2>
                <p class="text-3xl text-red-500 mt-2" id="cancelledTrips">{{$cancelledCount}}</p>
                <p class="text-gray-500 text-sm mt-2">Total trips cancelled today.</p>
            </div>
        </div>

                <section class="mx-auto">
            @if($currentQueueDriver && $driverDetails)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-blue-600 px-6 py-3 flex justify-between items-center">
                    <span class="text-white font-bold tracking-wider uppercase text-sm">Next in Line</span>
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
                                {{ $currentQueueDriver->created_at->format('g:i A') }}
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
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">License No.</label>
                            <p class="text-gray-800 font-semibold">{{ $driverDetails->license_number ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">Contact</label>
                            <p class="text-gray-800 font-semibold">{{ $driverDetails->contact_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl p-12 text-center">
                <p class="text-gray-500 font-medium text-lg">The queue is currently empty.</p>
            </div>
            @endif
        </section>

        <!-- Ongoing Drivers Table Section -->
        <section class="bg-blue-50 rounded-md overflow-hidden mt-6">
            <div class="w-full bg-[#0054A1] rounded-md h-12 px-4 py-1.5 flex items-center ">
                <p class="font-bold text-white">Trip History</p>
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-body mt-4">
                <thead class="bg-neutral-secondary-soft border-b border-default">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-bold text-gray-800">
                            Driver Name
                        </th>
                        <th scope="col" class="px-6 py-3 font-bold text-gray-800">
                            Tricycle ID
                        </th>
                        <th scope="col" class="px-6 py-3 font-bold text-gray-800">
                            Dispatch Time
                        </th>
                        <th scope="col" class="px-6 py-3 font-bold text-gray-800">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if($ongoingRides->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">
                            No available data
                        </td>
                    </tr>
                    @else
                    @foreach($ongoingRides as $ride)
                    <tr class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-default">
                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $ride->driver->username }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $ride->tricycle_id }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $ride->dispatch_at->format('H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-orange-500">{{ $ride->status }}</span>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $ongoingRides->links() }}
            </div>
        </section>

        <section class="bg-white p-6 rounded-md shadow-xs border border-gray-200 mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Tricycle Routes in Bayambang Ligue</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12355.505685726233!2d120.41852693241148!3d15.824830607113638!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33914f27477d6d3f%3A0xd1241caa3394b6d9!2sLigue%2C%20Bayambang%2C%20Pangasinan!5e1!3m2!1sen!2sph!4v1771696502669!5m2!1sen!2sph" class="w-full h-96" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </section>

    </div>
</div>
@endsection