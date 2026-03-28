@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
    <div class="max-w-4xl mx-auto">
        <header class="mb-8">
                <div class="flex items-center gap-2 text-sm text-indigo-600 font-bold mb-2">
                <a href="{{ route('admin.fare.index') }}" class="hover:underline flex items-center gap-1">
                    <x-tabler-arrow-left class="w-4 h-4" /> Back to List
                </a>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Create Fare Description</h1>
            <p class="text-gray-500 mt-1">Define a new pricing structure for the transport system.</p>
        </header>

        <div class="bg-white border border-gray-100 rounded-3xl shadow-sm overflow-hidden">
            <form action="{{ route('admin.fare.store') }}" method="POST" class="p-8">
                @csrf

                <div class="space-y-6">
                    {{-- Label/Name of the Fare --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Fare Label / Name</label>
                        <input type="text" name="label" value="{{ old('label') }}"
                            placeholder="e.g., Standard Rate, Holiday Peak, Weekend Special"
                            class="w-full border border-gray-300 rounded-xl p-3 mt-2 focus:ring-2 focus:ring-indigo-500 outline-none @error('label') border-red-500 @enderror" required>
                        @error('label') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Fare Inputs Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Base Fare (₱)</label>
                            <input type="number" step="0.01" name="trip_fare" value="{{ old('trip_fare', 0.00) }}"
                                class="w-full border border-gray-300 rounded-xl p-3 mt-2 outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>
                        {{-- <div>
                            <label class="block text-sm font-bold text-gray-700">Terminal Fare (₱)</label>
                            <input type="number" step="0.01" name="terminal_fare" value="{{ old('terminal_fare', 0.00) }}"
                                class="w-full border border-gray-300 rounded-xl p-3 mt-2 outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div> --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Special Trip (₱)</label>
                            <input type="number" step="0.01" name="hire_fare" value="{{ old('hire_fare', 0.00) }}"
                                class="w-full border border-gray-300 rounded-xl p-3 mt-2 outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>
                    </div>

                    {{-- Activation Toggle --}}
                    <div class="bg-indigo-50/50 p-4 rounded-2xl border border-indigo-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                                    <x-tabler-bolt class="w-6 h-6" />
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">Set as Current Active Fare</p>
                                    <p class="text-xs text-gray-500">Enabling this will automatically deactivate the previous active fare.</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_current" value="1" class="sr-only peer" {{ old('is_current') ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-50">
                 <div></div>

                        <div class="flex gap-4 items-center">
                            <a href="{{ route('admin.fare.index') }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700">Cancel</a>
                            <button type="submit" class="px-10 py-3 bg-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all">
                                Save Fare Description
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection