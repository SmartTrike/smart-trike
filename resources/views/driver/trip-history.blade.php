@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
    <div class="max-w-6xl mx-auto">
        
        <header class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Trip History</h1>
                    <p class="text-gray-500 mt-1">Detailed log of your past dispatches and returns.</p>
                </div>
                
                <div class="flex gap-4">
                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm min-w-[120px]">
                        <span class="block text-2xs uppercase font-bold text-gray-400">Total Trips</span>
                        <span class="text-2xl font-black text-gray-900">{{ $trips->total() }}</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="mb-6">
            <form action="{{ route('driver.tripHistory') }}" method="GET" class="flex gap-2">
                <div class="relative flex-1 max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-heroicon-o-magnifying-glass class="w-5 h-5 text-gray-400" />
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Search..." 
                        class="block w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-gray-900 text-sm">
                </div>
                <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-black transition-all">
                    Filter
                </button>
            </form>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Dispatch Details</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400 text-center">Passengers</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Duration</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Status</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($trips as $trip)
                        <tr class="hover:bg-gray-50/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">
                                    {{ $trip->dispatch_at ? $trip->dispatch_at->format('M d, Y') : '—' }}
                                </div>
                                <div class="text-xs text-gray-500 font-mono">
                                    {{ $trip->dispatch_at ? $trip->dispatch_at->format('h:i A') : '—' }}
                                </div>
                                <div class="text-2xs text-gray-400 mt-1 italic">ID: #{{ $trip->id }}</div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-gray-100 text-gray-800">
                                    <x-heroicon-s-users class="w-4 h-4 mr-1 text-gray-400" />
                                    {{ $trip->passenger_count }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                @if($trip->returned_at)
                                    <div class="text-sm font-medium text-gray-700">
                                        {{ round($trip->dispatch_at->diffInMinutes($trip->returned_at, false)) }} mins
                                    </div>
                                    <div class="text-2xs text-gray-400 uppercase">
                                        Back at {{ $trip->returned_at->format('h:i A') }}
                                    </div>
                                @else
                                    <span class="text-xs text-amber-500 font-bold animate-pulse">In Progress</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @php
                                    $colors = [
                                        'completed' => 'bg-green-100 text-green-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                        'ongoing'   => 'bg-blue-100 text-blue-700'
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-2xs font-bold uppercase tracking-wider {{ $colors[$trip->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $trip->status }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <p class="text-xs text-gray-500 italic max-w-[150px] truncate" title="{{ $trip->remarks }}">
                                    {{ $trip->remarks ?? 'No remarks' }}
                                </p>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-gray-400 italic">
                                No trips recorded yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($trips->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $trips->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection