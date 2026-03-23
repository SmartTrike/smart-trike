@extends('layouts.dashboard')

@section('content')
    <div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
        <div class="max-w-5xl mx-auto">

            <div class="mb-6 flex items-center justify-between">
                <a href="{{ route('viewReport') }}"
                    class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Reports
                </a>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold uppercase tracking-widest text-gray-400">Report ID:</span>
                    <span
                        class="text-sm font-mono font-bold text-gray-900">#{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-3xl shadow-sm overflow-hidden">
                <div class="p-8 border-b border-gray-50 bg-gray-50/30">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Incident Review</h2>
                            <p class="text-gray-500">Submitted on {{ $report->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            @php
                                $statusColors = [
                                    'reported' => 'bg-blue-100 text-blue-700',
                                    'invalid' => 'bg-red-100 text-red-700',
                                    'approved' => 'bg-green-100 text-green-700',
                                ];
                            @endphp
                            <span
                                class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest {{ $statusColors[$report->status] ?? 'bg-gray-100' }}">
                                {{ $report->status }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 divide-y lg:divide-y-0 lg:divide-x divide-gray-100">
                    <div class="lg:col-span-2 p-8 space-y-8">
                        <div>
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-3">Incident Description
                            </h3>
                            <p class="text-gray-700 leading-relaxed bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                {{ $report->description }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-3">Driver Involved
                                </h3>
                                <div class="flex items-center gap-3 p-3 border border-gray-100 rounded-2xl">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gray-900 flex items-center justify-center text-white font-bold text-xs">
                                        {{ strtoupper(substr($report->driver->username ?? 'D', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">
                                            {{ $report->driver->username ?? 'Unknown' }}</div>
                                        <div class="text-xs text-gray-500">{{ $report->driver->email ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-3">Incident Timing
                                </h3>
                                <div class="p-3 border border-gray-100 rounded-2xl space-y-1">
                                    <div class="text-sm font-bold text-gray-900">
                                        {{ \Carbon\Carbon::parse($report->event_date)->format('F j, Y') }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($report->event_date)->format('h:i A') }} (Local Time)
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($report->remarks)
                            <div>
                                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-3">Admin Remarks
                                </h3>
                                <p class="text-sm text-gray-600 italic">"{{ $report->remarks }}"</p>
                            </div>
                        @endif
                    </div>

                    <div class="p-8 bg-gray-50/20">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Evidence Image</h3>

                        @if ($report->evidence_image_path)
                            <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-sm bg-white">
                                {{-- Proper Blade Component Tag --}}
                                <x-cloudinary::image public-id="{{ $report->evidence_image_path }}" width="auto" crop="scale"
                                    class="w-full h-auto object-cover hover:scale-105 transition-transform duration-500"
                                    alt="Evidence" ></x-cloudinary::image>
                            </div>

                            {{-- The Full Image Link --}}
                            <a href="{{ Storage::disk('cloudinary')->url($report->evidence_image_path) }}" target="_blank"
                                class="mt-4 flex items-center justify-center text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                VIEW FULL IMAGE
                            </a>
                        @else
                            <div
                                class="rounded-2xl border-2 border-dashed border-gray-200 h-48 flex flex-col items-center justify-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs font-medium">No Evidence Uploaded</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Action Bar: Only visible for Admin AND if report is still 'reported' --}}
                @if (Auth::user()->role === 'admin' && $report->status === 'reported')
                    <div class="p-8 bg-white border-t border-gray-100 flex flex-wrap gap-4 justify-between items-center">
                        {{-- <div class="flex gap-3">
             
                    <a href="" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all">
                        Edit Report
                    </a>
                </div> --}}

                        <div></div>

                        <div class="flex flex-wrap gap-3">
                            {{-- Invalidate Button --}}
                            <form action="{{ route('reports.invalidate', $report->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to invalidate this report?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="px-6 py-2.5 border-2 border-red-50 text-red-600 rounded-xl text-sm font-bold hover:bg-red-50 transition-all">
                                    Invalidate Report
                                </button>
                            </form>
                            {{-- Approve Button --}}
                            <a href="{{ route('violation.create', ['report_id' => $report->id]) }}"
                                class="px-6 py-2.5 bg-green-600 text-white rounded-xl text-sm font-bold hover:bg-green-700 shadow-lg shadow-green-100 transition-all flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Approve & Create Violation
                            </a>
                        </div>
                    </div>
                @elseif($report->status !== 'reported')
                    {{-- Optional: Show a message for closed cases --}}
                    <div class="p-6 bg-gray-50 border-t border-gray-100 text-center">
                        <p class="text-sm font-medium text-gray-500 italic">
                            This report is <strong>{{ $report->status }}</strong>. No further actions can be taken.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
