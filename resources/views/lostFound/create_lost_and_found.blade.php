@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
    <div class="max-w-6xl mx-auto">

        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Report a Lost or Found Item</h1>
            <p class="text-gray-500 mt-1">Fill out the form to report a new lost or found item.</p>
        </header>

        <!-- Lost Item Report Form -->
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden p-6">
            <form action="{{ route('storeLostAndFound') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <!-- Item Name -->
                    <div>
                        <label for="item_name" class="block text-sm font-medium text-gray-700">Item Name</label>
                        <input type="text" name="item_name" id="item_name" value="{{ old('item_name') }}" class="w-full border border-gray-300 rounded-md p-2 mt-2" required>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Item Description</label>
                        <input type="text" name="description" id="description" value="{{ old('description') }}" class="w-full border border-gray-300 rounded-md p-2 mt-2" required>
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" id="type" class="w-full border border-gray-300 rounded-md p-2 mt-2" required>
                            <option value="lost" {{ old('type') == 'lost' ? 'selected' : '' }}>Lost</option>
                            <option value="found" {{ old('type') == 'found' ? 'selected' : '' }}>Found</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <!-- <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" class="w-full border border-gray-300 rounded-md p-2 mt-2" required>
                            <option value="reported" {{ old('status') == 'reported' ? 'selected' : '' }}>Reported</option>
                            <option value="claimed" {{ old('status') == 'claimed' ? 'selected' : '' }}>Claimed</option>
                            <option value="returned" {{ old('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                            <option value="disposed" {{ old('status') == 'disposed' ? 'selected' : '' }}>Disposed</option>
                        </select>
                    </div> -->

                    <!-- Date Found/Lost -->
                    <div>
                        <label for="date_found_lost" class="block text-sm font-medium text-gray-700">Date Found/Lost</label>
                        <input type="date" name="date_found_lost" id="date_found_lost" value="{{ old('date_found_lost') }}" class="w-full border border-gray-300 rounded-md p-2 mt-2" required>
                    </div>

                    <!-- Location Found/Lost -->
                    <div>
                        <label for="location_found_lost" class="block text-sm font-medium text-gray-700">Location Found/Lost</label>
                        <input type="text" name="location_found_lost" id="location_found_lost" value="{{ old('location_found_lost') }}" class="w-full border border-gray-300 rounded-md p-2 mt-2" required>
                    </div>

                    <!-- Remarks -->
                    <div>
                        <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                        <textarea name="remarks" id="remarks" class="w-full border border-gray-300 rounded-md p-2 mt-2">{{ old('remarks') }}</textarea>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">Item Image (optional)</label>
                        <input type="file" name="image" id="image" accept="image/*" class="w-full border border-gray-300 rounded-md p-2 mt-2">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-500">
                            Report Item
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection