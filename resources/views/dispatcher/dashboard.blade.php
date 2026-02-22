@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-white md:bg-gray-50/30 p-4 lg:p-10 overflow-y-auto">
    <div class="w-full space-y-6">

        <!-- Header Section -->
        <header class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Welcome, {{ auth()->user()->username }}</h1>
            <p class="text-lg text-gray-500 mt-2">{{ now()->format('l, F j, Y \a\t g:i A') }}</p>
        </header>

        <!-- Current Queue Section -->
        <section class="mx-auto">
            @if($firstQueueDriver && $driverDetails)
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
                                {{ $firstQueueDriver->created_at->format('g:i A') }}
                            </p>
                        </div>
                    </div>

                    <hr class="my-6 border-gray-100">

                    <!-- Update Status Form -->
                    <form action="" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">Passenger Count</label>
                                <input type="number" name="passenger_count" class="w-full p-2 border border-gray-300 rounded" required />
                            </div>
                        </div>
                        <button type="submit" class="mt-4 bg-green-500 text-white p-3 rounded">Set On Ride</button>
                   
                    </form>

         
                </div>
            </div>
            @else
            <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl p-12 text-center">
                <p class="text-gray-500 font-medium text-lg">The queue is currently empty.</p>
            </div>
            @endif
        </section>



    </div>
</div>
@endsection