@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
    <div class=" mx-auto">
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('viewViolationList') }}" class="text-sm font-bold text-red-600 hover:text-red-700 flex items-center gap-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
            <h1 class="text-3xl font-bold text-gray-900">File New Violation</h1>
            <p class="text-gray-500">Record an official infraction and set suspension parameters.</p>
        </div>

        <form action="{{ route('storeNewViolation') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 lg:p-8 space-y-6">
                
                {{-- Driver Selection --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Select Driver</label>
                    <select name="driver_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-red-500 outline-none transition-all">
                        <option value="">-- Choose a Driver --</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                {{ $driver->username }} ({{ $driver->driverInfo->contact_number }} )
                            </option>
                        @endforeach
                    </select>
                    @error('driver_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Violation Title --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Violation Type</label>
                    <input type="text" name="violation" value="{{ old('violation') }}" 
                           placeholder="e.g., Reckless Driving, Route Abandonment"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-red-500 outline-none transition-all">
                    @error('violation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Suspension Days --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Suspension (Days)</label>
                        <input type="number" name="suspension_days" value="{{ old('suspension_days', 0) }}" min="0"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-red-500 outline-none transition-all">
                        @error('suspension_days') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Start Date --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Start Date</label>
                        <input type="date" name="suspension_start_date" value="{{ old('suspension_start_date', date('Y-m-d')) }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-red-500 outline-none transition-all">
                        @error('suspension_start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Remarks --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Additional Remarks</label>
                    <textarea name="remarks" rows="4" 
                              placeholder="Provide details regarding the incident..."
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-red-500 outline-none transition-all">{{ old('remarks') }}</textarea>
                    @error('remarks') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-gray-900 text-white py-4 rounded-2xl font-bold hover:bg-black transition-all shadow-lg shadow-gray-200">
                    Register Violation
                </button>
                <a href="{{ route('viewViolationList') }}" class="px-8 py-4 bg-white border border-gray-200 text-gray-600 rounded-2xl font-bold hover:bg-gray-50 transition-all text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection