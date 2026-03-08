@extends('layouts.dashboard')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 p-6">
        <div class=" w-full text-center">
            {{-- Warning Icon --}}
            <div class="mb-6 inline-flex items-center justify-center w-20 h-20 bg-red-100 text-red-600 rounded-full">
                <x-heroicon-o-no-symbol class="h-10 w-10" />
            </div>

            <h1 class="text-3xl font-black text-gray-900 mb-2">Account Restricted</h1>
            <p class="text-gray-500 mb-8">You are currently under administrative suspension and cannot join the queue or
                accept rides.</p>

            <div class="bg-white border border-red-100 rounded-2xl p-6 shadow-sm mb-8 text-left">
                <div class="mb-4">
                    <label class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Reason</label>
                    <p class="text-gray-900 font-bold">{{ $activeViolation->violation }}</p>
                </div>

                <div class="flex justify-between items-center">
                    <div>
                        <label class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Ends On</label>
                        <p class="text-gray-700 font-medium">{{ $activeViolation->suspension_end_date->format('M d, Y') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-xs font-bold">
                            {{ number_format(now()->diffInDays($activeViolation->suspension_end_date) + 1, 0) }} Days Left
                        </span>
                    </div>
                </div>
            </div>

            <a href="{{ route('driver.violation.show', $activeViolation->id) }}"
                class="inline-block w-full py-4 bg-gray-900 text-white rounded-2xl font-bold hover:bg-black transition-all">
                View Full Violation Report
            </a>

            <p class="mt-6 text-xs text-gray-400">
                If you believe this is an error, please contact the terminal office.
            </p>
        </div>
    </div>
@endsection
