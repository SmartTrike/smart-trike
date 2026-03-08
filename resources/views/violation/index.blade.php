@extends('layouts.dashboard')

@section('content')
    <div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
        <div class="max-w-6xl mx-auto">
            <header class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Driver Violations</h1>
                        <p class="text-gray-500 mt-1">Official records of driver infractions and active suspensions.</p>
                    </div>
                    <div class="flex gap-4">
                        {{-- Assuming you have a route to create a violation manually --}}
                        <a href="{{ route('createNewViolation') }}"
                            class="px-4 py-2 bg-red-600 text-white rounded-xl text-sm font-bold hover:bg-red-700 transition-all shadow-sm">
                            Issue New Violation
                        </a>
                    </div>
                </div>
            </header>

            {{-- Search Section --}}
            <div class="mb-6">
                <form action="{{ route('viewViolationList') }}" method="GET" class="flex gap-2">
                    <div class="relative flex-1 max-w-md">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by driver or violation type..."
                            class="block w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-red-500 text-sm outline-none">
                    </div>
                    <button type="submit"
                        class="px-6 py-2 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-black transition-all">
                        Search
                    </button>
                </form>
            </div>

            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50/50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Driver &
                                    Violation</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Penalty</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Suspension
                                    Period</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Filed By
                                </th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($violations as $violation)
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center text-red-600 border border-red-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-gray-900">
                                                    {{ $violation->driver->username ?? 'Unknown' }}</div>
                                                <div class="text-xs text-gray-500 line-clamp-1">{{ $violation->violation }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-orange-100 text-orange-700">
                                            {{ $violation->suspension_days }} Days
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($violation->suspension_start_date)
                                            <div class="text-sm text-gray-700">
                                                {{ $violation->suspension_start_date->format('M d') }} -
                                                {{ $violation->suspension_end_date->format('M d, Y') }}
                                            </div>
                                            <div class="text-xs text-gray-400">Fixed Duration</div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">No suspension set</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-700">{{ $violation->filer->username ?? 'System' }}
                                        </div>
                                        <div class="text-[10px] text-gray-400 uppercase font-semibold">Administrator</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center gap-4">
                                            <a href="{{ route('showViolation', $violation->id) }}"
                                                class="text-blue-600 font-bold hover:underline">View File</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-200 mb-4"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="text-gray-500 font-medium">No recorded violations.</p>
                                            <p class="text-xs text-gray-400 mt-1">All drivers are currently in good
                                                standing.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($violations->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        {{ $violations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
