@extends('layouts.dashboard')

@section('content')
    <div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
        <div class=" mx-auto">
            <a href="{{ route('driver.violations') }}"
                class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-700 mb-6 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to My Violations
            </a>

            <div class="bg-white border border-gray-100 rounded-3xl shadow-sm overflow-hidden">
                {{-- Header/Notice --}}
                <div class="bg-red-600 p-8 text-white">
                    <h2 class="text-2xl font-bold">{{ $violation->violation }}</h2>
                    <p class="opacity-80 mt-1">Official Infraction Notice</p>
                </div>

                <div class="p-8 space-y-8">
                    {{-- Suspension Details --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-1">
                            <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Duration</p>
                            <p class="text-2xl font-black text-gray-900">{{ $violation->suspension_days }} Days</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Effective Period</p>
                            <p class="text-lg font-bold text-gray-700">
                                {{ $violation->suspension_start_date->format('M d, Y') }} —
                                {{ $violation->suspension_end_date->format('M d, Y') }}
                            </p>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    {{-- Admin Remarks --}}
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 mb-3">Administrator Remarks</h3>
                        <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 text-gray-700 italic leading-relaxed">
                            "{{ $violation->remarks ?? 'No specific remarks provided.' }}"
                        </div>
                        <p class="mt-3 text-xs text-gray-400">Recorded by: Administrator
                            {{ $violation->filer->username ?? 'System' }}</p>
                    </div>

                    {{-- Evidence from Report --}}
                    @if ($violation->report && $violation->report->evidence_image_path)
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 mb-3">Supporting Evidence</h3>
                            <div class="rounded-2xl overflow-hidden border border-gray-200 bg-gray-100">
                                <img src="{{ Cloudinary::getImage($violation->report->evidence_image_path)->delivery('q_auto')->delivery('f_auto')->resize('fill', 800, 600)->toUrl() }}"
                                    class="w-full object-cover max-h-96" alt="Violation Evidence">
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Appeal Notice --}}
            <div class="mt-8 p-6 bg-blue-50 rounded-2xl border border-blue-100 flex items-start gap-4">
                <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-blue-900">Need to appeal this?</h4>
                    <p class="text-xs text-blue-700 mt-1 leading-relaxed">If you believe this violation was issued in error,
                        please visit the main office with your Case ID:
                        #VL-{{ str_pad($violation->id, 5, '0', STR_PAD_LEFT) }}.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
