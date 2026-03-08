@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
    <div class=" mx-auto">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">My Violations</h1>
            <p class="text-gray-500 mt-1">Review your record and track suspension periods.</p>
        </header>

        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Violation</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Status</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Period</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($violations as $violation)
                    @php
                        $isActive = now()->between($violation->suspension_start_date, $violation->suspension_end_date);
                    @endphp
                    <tr class="hover:bg-gray-50/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $violation->violation }}</div>
                            <div class="text-xs text-gray-400">Filed on {{ $violation->created_at->format('M d, Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($isActive)
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-bold uppercase tracking-wider">Currently Suspended</span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-[10px] font-bold uppercase tracking-wider">Resolved / Past</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-700">{{ $violation->suspension_days }} Days</div>
                            <div class="text-xs text-gray-400">{{ $violation->suspension_start_date->format('M d') }} - {{ $violation->suspension_end_date->format('M d, Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('driver.violation.show', $violation->id) }}" class="text-blue-600 font-bold text-sm hover:underline">View Details</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <p class="text-gray-500 font-medium">No violations on record.</p>
                            <p class="text-xs text-gray-400 mt-1">Keep up the safe driving!</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection