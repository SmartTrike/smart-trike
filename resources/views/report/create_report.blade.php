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
            <form action="{{ route('storeNewReport') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-8">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="driver_id" class="block text-sm font-semibold text-gray-700">Driver Involved</label>
                            <select name="driver_id" id="driver_id" class="w-full border border-gray-300 rounded-lg p-2.5 mt-2 focus:ring-2 focus:ring-blue-500 @error('driver_id') border-red-500 @enderror" required>

                                @if(isset($drivers) && $drivers->count() > 0)
                                <option value="" selected disabled>-- Select the driver involved --</option>
                                @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                    {{ $driver->username }} ({{ $driver->driverInfo->contact_number  }})
                                </option>
                                @endforeach
                                @else
                                <option value="" disabled>No drivers available in the system</option>
                                @endif

                            </select>

                            {{-- Validation Error Message --}}
                            @error('driver_id')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="event_date" class="block text-sm font-semibold text-gray-700">Date and Time of Incident</label>
                            <input type="datetime-local" name="event_date" id="event_date" value="{{ old('event_date') }}" class="w-full border border-gray-300 rounded-lg p-2.5 mt-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700">Incident Description</label>
                        <p class="text-xs text-gray-500 mb-2">Provide a clear and detailed account of what happened.</p>
                        <textarea name="description" id="description" rows="4" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500" placeholder="Describe the incident..." required>{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Evidence Image</label>
                        <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="evidence_image_path" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                        <span>Upload a file</span>
                                        <input id="evidence_image_path" name="evidence_image_path" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="remarks" class="block text-sm font-semibold text-gray-700">Additional Remarks <span class="text-gray-400 font-normal">(Optional)</span></label>
                        <input type="text" name="remarks" id="remarks" value="{{ old('remarks') }}" class="w-full border border-gray-300 rounded-lg p-2.5 mt-2 focus:ring-2 focus:ring-blue-500" placeholder="Any other notes for the reviewer...">
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                        <a href="" class="text-sm font-semibold text-gray-600 hover:text-gray-800">Cancel</a>
                        <button type="submit" class="px-8 py-3 bg-red-600 text-white font-bold rounded-xl shadow-md hover:bg-red-700 transform transition-transform hover:-translate-y-0.5 active:scale-95">
                            Submit Report
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection