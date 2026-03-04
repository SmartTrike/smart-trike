@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
    <div class="max-w-4xl mx-auto">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Issue Official Violation</h1>
            <p class="text-gray-500 mt-1">Approving report #{{ $report->id }} for Driver: <strong>{{ $report->driver->username }} ({{ $report->driver->driverInfo->contact_number ?? '' }})</strong></p>
        </header>

        <div class="bg-white border border-gray-100 rounded-3xl shadow-sm overflow-hidden">
            <form action="{{ route('violation.store') }}" method="POST" class="p-8">
                @csrf
                <input type="hidden" name="report_id" value="{{ $report->id }}">

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Violation Title</label>
                        <input type="text" name="violation" value="{{ old('violation') }}"
                            placeholder="e.g., Reckless Driving, Unauthorized Route"
                            class="w-full border border-gray-300 rounded-xl p-3 mt-2 focus:ring-2 focus:ring-green-500 outline-none" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Suspension Days</label>
                            <input type="number" name="suspension_days" value="{{ old('suspension_days', 0) }}"
                                class="w-full border border-gray-300 rounded-xl p-3 mt-2 outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Start Date</label>
                            <input type="date" name="suspension_start_date"
                                class="w-full border border-gray-300 rounded-xl p-3 mt-2 outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700">End Date</label>
                            <input type="date" name="suspension_end_date"
                                class="w-full border border-gray-300 rounded-xl p-3 mt-2 outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700">Final Decision Remarks</label>
                        <textarea name="remarks" rows="4" placeholder="Explain the reason for this punishment..."
                            class="w-full border border-gray-300 rounded-xl p-3 mt-2 outline-none focus:ring-2 focus:ring-green-500">{{ old('remarks') }}</textarea>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-50">
                        <div class="flex items-center gap-2 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs font-medium">This action will notify the driver.</span>
                        </div>

                        <div class="flex gap-4">
                            <a href="{{ route('showReport', $report->id) }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700">Cancel</a>
                            <button type="submit" class="px-10 py-3 bg-green-600 text-white rounded-xl font-bold shadow-lg shadow-green-100 hover:bg-green-700 transition-all">
                                Confirm & Issue Violation
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection