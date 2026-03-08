@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
    <div class="max-w-4xl mx-auto">
        {{-- Navigation & Title --}}
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('viewViolationList') }}" class="p-2 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Violation Details</h1>
                <p class="text-sm text-gray-500">Case ID: #VL-{{ str_pad($violation->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="md:col-span-2 space-y-6">
                {{-- Violation Info --}}
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-lg font-bold text-gray-900">Infraction Summary</h2>
                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold uppercase">
                            {{ $violation->suspension_days }} Day Suspension
                        </span>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Violation Type</label>
                            <p class="text-gray-900 font-medium">{{ $violation->violation }}</p>
                        </div>

                        <div>
                            <label class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Administrative Remarks</label>
                            <div class="mt-1 p-4 bg-gray-50 rounded-xl text-sm text-gray-700 leading-relaxed border border-gray-100">
                                {{ $violation->remarks ?? 'No additional remarks provided.' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Evidence Section (From related Report) --}}
                @if($violation->report && $violation->report->evidence_image_path)
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Supporting Evidence</h2>
                    <img src="{{ asset('storage/' . $violation->report->evidence_image_path) }}" 
                         alt="Evidence" 
                         class="w-full h-auto rounded-xl border border-gray-100 shadow-inner">
                </div>
                @endif
            </div>

            {{-- Sidebar Details --}}
            <div class="space-y-6">
                {{-- Driver Card --}}
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                    <h3 class="text-sm font-bold text-gray-900 mb-4">Driver Involved</h3>
                    <div class="flex items-center gap-3">
                        <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold border border-gray-200">
                            {{ substr($violation->driver->username, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ $violation->driver->username }}</p>
                        </div>
                    </div>
                </div>

                {{-- Timeline Card --}}
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                    <h3 class="text-sm font-bold text-gray-900 mb-4">Dates & Logging</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="mt-1 p-1.5 bg-blue-50 text-blue-600 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase font-bold text-gray-400">Suspension Starts</p>
                                <p class="text-sm font-medium text-gray-700">{{ $violation->suspension_start_date?->format('F d, Y') ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="mt-1 p-1.5 bg-red-50 text-red-600 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase font-bold text-gray-400">Suspension Ends</p>
                                <p class="text-sm font-medium text-gray-700">{{ $violation->suspension_end_date?->format('F d, Y') ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <hr class="border-gray-50">

                        <div>
                            <p class="text-[10px] uppercase font-bold text-gray-400">Issued By</p>
                            <p class="text-sm font-medium text-gray-700">{{ $violation->filer->username ?? 'System' }}</p>
                            <p class="text-[10px] text-gray-400">{{ $violation->created_at->format('M d, Y @ h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection