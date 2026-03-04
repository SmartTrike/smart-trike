@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
    <div class="max-w-6xl mx-auto">
        <header class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    {{-- Updated Header Title --}}
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Incidents & Violations</h1>
                    <p class="text-gray-500 mt-1">Manage and review driver conduct reports and official violations.</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('createNewReport') }}" class="px-4 py-2 bg-red-600 text-white rounded-xl text-sm font-bold hover:bg-red-700 transition-all shadow-sm">
                        File New Incident
                    </a>
                </div>
            </div>
        </header>

        {{-- Search/Filter Section --}}
        <div class="mb-6">
            <form action="{{ route('viewReportViolation') }}" method="GET" class="flex gap-2">
                <div class="relative flex-1 max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by driver name or description..."
                        class="block w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-red-500 text-sm outline-none">
                </div>
                <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-black transition-all">
                    Filter
                </button>
            </form>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50 border-b border-gray-100">
                        <tr>
                            {{-- Updated Columns based on Migration --}}
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Driver & Incident</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Status</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Incident Date</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($reports as $report)
                        <tr class="hover:bg-gray-50/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($report->evidence_image_path)
                                    <img src="{{ asset('storage/' . $report->evidence_image_path) }}" class="w-10 h-10 rounded-lg object-cover border border-gray-100">
                                    @else
                                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    @endif
                                    <div>
                                        {{-- Shows Driver Name --}}
                                        <div class="text-sm font-bold text-gray-900 line-clamp-1">{{ $report->driver->username ?? 'Unknown Driver' }}</div>
                                        <div class="text-xs text-gray-500 line-clamp-1">{{ $report->description }}</div>
                                    </div>
                                </div>
                            </td>


                            <td class="px-6 py-4">
                                @php
                                $statusColors = [
                                'reported' => 'bg-blue-100 text-blue-700',
                                'invalid' => 'bg-red-100 text-red-700',
                                'approved' => 'bg-green-100 text-green-700',
                                ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusColors[$report->status] ?? 'bg-gray-100' }}">
                                    {{ $report->status }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{-- Use event_date from migration --}}
                                <div class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($report->event_date)->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($report->event_date)->format('h:i A') }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('showReport', $report->id) }}" class="text-blue-600 font-bold hover:underline">Review Details</a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-200 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-gray-500 font-medium">No incident reports found.</p>
                                    <p class="text-xs text-gray-400 mt-1">Clean slate! No violations currently on record.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($reports->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $reports->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection