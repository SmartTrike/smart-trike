@extends('layouts.dashboard')

@section('content')
    <div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
        <div class="max-w-6xl mx-auto">

            <header class="mb-8">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-red-100 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">File an Incident Report</h1>
                        <p class="text-gray-500 mt-1">Please provide accurate details regarding the driver's conduct or incident.</p>
                    </div>
                </div>
            </header>

            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden p-8">
                {{-- Global Error Alert --}}
                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm font-medium rounded-r-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('storeNewReport') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Driver Select --}}
                            <div>
                                <label for="driver_id" class="block text-sm font-semibold text-gray-700">Driver Involved</label>
                                <select name="driver_id" id="driver_id"
                                    class="w-full border rounded-lg p-2.5 mt-2 focus:ring-2 focus:ring-blue-500 @error('driver_id') border-red-500 bg-red-50 @else border-gray-300 @enderror">
                                    <option value="" selected disabled>-- Select the driver --</option>
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                            {{ $driver->username }} ({{ $driver->driverInfo->contact_number ?? 'No Contact' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('driver_id')
                                    <p class="mt-1 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Event Date --}}
                            <div>
                                <label for="event_date" class="block text-sm font-semibold text-gray-700">Date and Time of Incident</label>
                                <input type="datetime-local" name="event_date" id="event_date"
                                    value="{{ old('event_date') }}"
                                    class="w-full border rounded-lg p-2.5 mt-2 focus:ring-2 focus:ring-blue-500 @error('event_date') border-red-500 bg-red-50 @else border-gray-300 @enderror">
                                @error('event_date')
                                    <p class="mt-1 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700">Incident Description</label>
                            <p class="text-xs text-gray-500 mb-2">Provide a clear and detailed account of what happened.</p>
                            <textarea name="description" id="description" rows="4"
                                class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 bg-red-50 @else border-gray-300 @enderror"
                                placeholder="Describe the incident...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Evidence Image --}}
                        <div>
                            <label for="evidence_image_path" class="block text-sm font-semibold text-gray-700">Evidence Image</label>
                            <input type="file" id="evidence_image_path" name="evidence_image_path" accept="image/*"
                                class="mt-2 block w-full text-sm text-gray-700 border rounded-md p-2 focus:ring-blue-500 @error('evidence_image_path') border-red-500 bg-red-50 @else border-gray-300 @enderror">
                            @error('evidence_image_path')
                                <p class="mt-1 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Remarks --}}
                        <div>
                            <label for="remarks" class="block text-sm font-semibold text-gray-700">Additional Remarks</label>
                            <input type="text" name="remarks" id="remarks" value="{{ old('remarks') }}"
                                class="w-full border rounded-lg p-2.5 mt-2 focus:ring-2 focus:ring-blue-500 @error('remarks') border-red-500 bg-red-50 @else border-gray-300 @enderror"
                                placeholder="Any other notes...">
                            @error('remarks')
                                <p class="mt-1 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('viewReport') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-800 transition-colors">Cancel</a>
                            <button type="submit"
                                class="px-8 py-3 bg-red-600 text-white font-bold rounded-xl shadow-md hover:bg-red-700 transform transition-all active:scale-95">
                                Submit Report
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection