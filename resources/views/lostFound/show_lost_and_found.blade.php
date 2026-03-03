@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
    <div class="max-w-5xl mx-auto">
        
        <nav class="mb-6">
            <a href="{{ route('lostAndFound') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
                <x-heroicon-o-chevron-left class="w-4 h-4 mr-1" />
                Back to Lost and Found List
            </a>
        </nav>

        @if($item->type === 'found' && $item->status === 'reported')
            <div class="mb-8 bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-2xl shadow-sm">
                <div class="flex items-center">
                    <div class="fshrink-0">
                        <x-heroicon-s-exclamation-triangle class="h-5 w-5 text-amber-400" />
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-amber-800 font-bold uppercase tracking-tight">Security Protocol</p>
                        <p class="text-sm text-amber-700">
                            Please surrender the found item to the Main Terminal Office as soon as possible. Staff will keep the item safe until the owner claims it.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <header class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Item Details</h1>
                <p class="text-gray-500 mt-1 uppercase text-xs font-bold tracking-widest">Case ID: #{{ $item->id }}</p>
            </div>
            
            <div class="flex items-center">
                @php
                    $statusColors = [
                        'reported' => 'bg-blue-100 text-blue-700 border-blue-200',
                        'claimed'  => 'bg-amber-100 text-amber-700 border-amber-200',
                        'returned' => 'bg-green-100 text-green-700 border-green-200',
                        'disposed' => 'bg-gray-100 text-gray-700 border-gray-200',
                    ];
                @endphp
                <span class="px-4 py-1.5 rounded-full border text-xs font-bold uppercase tracking-widest {{ $statusColors[$item->status] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ $item->status }}
                </span>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden p-2">
                    @if($item->image_path)
                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->item_name }}" class="w-full h-80 object-cover rounded-xl shadow-inner">
                    @else
                        <div class="w-full h-80 bg-gray-100 rounded-xl flex flex-col items-center justify-center text-gray-400">
                            <x-heroicon-o-photo class="w-16 h-16 mb-2 opacity-20" />
                            <span class="text-xs font-medium uppercase tracking-widest">No Image Provided</span>
                        </div>
                    @endif
                </div>

                @if(Auth::user()->isAdmin() || Auth::user()->isDispatcher())
                <div class="bg-white border border-gray-900 shadow-xl rounded-2xl p-6">
                    <h3 class="text-sm font-black uppercase tracking-widest text-gray-900 mb-4 flex items-center">
                        <x-heroicon-o-cog-6-tooth class="w-4 h-4 mr-2" />
                        Management
                    </h3>
                    <form action="{{ route('updateLostAndFoundStatus', $item->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label class="block text-2xs font-bold text-gray-400 uppercase mb-1">Change Status</label>
                            <select name="status" class="w-full border-gray-200 rounded-xl text-sm focus:ring-gray-900">
                                <option value="reported" {{ $item->status == 'reported' ? 'selected' : '' }}>Reported</option>
                                <option value="claimed" {{ $item->status == 'claimed' ? 'selected' : '' }}>Claimed (Waiting for Pickup)</option>
                                <option value="returned" {{ $item->status == 'returned' ? 'selected' : '' }}>Returned to Owner</option>
                                <option value="disposed" {{ $item->status == 'disposed' ? 'selected' : '' }}>Disposed</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-2xs font-bold text-gray-400 uppercase mb-1">Internal Remarks</label>
                            <textarea name="remarks" rows="2" class="w-full border-gray-200 rounded-xl text-sm focus:ring-gray-900" placeholder="Notes for staff...">{{ $item->remarks }}</textarea>
                        </div>

                        <button type="submit" class="w-full py-3 bg-gray-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-black transition-all">
                            Save Updates
                        </button>
                    </form>
                </div>
                @endif
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-8 h-full">
                    
                    <div class="border-b border-gray-100 pb-4 mb-6">
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">{{ $item->type }} Report</span>
                        <h2 class="text-2xl font-bold text-gray-900 mt-1">{{ $item->item_name }}</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Reported By</label>
                            <div class="flex items-center gap-2">
                                <p class="text-gray-900 font-semibold">{{ $item->reporter->username ?? 'Unknown User' }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Date Reported</label>
                            <p class="text-gray-900 font-semibold">{{ $item->created_at->format('F d, Y') }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Location Found/Lost</label>
                            <p class="text-gray-900 font-medium">{{ $item->location_found_lost ?? 'Not specified' }}</p>
                        </div>

                        <div class="md:col-span-2 bg-gray-50 rounded-xl p-5">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Description</label>
                            <p class="text-gray-700 leading-relaxed">{{ $item->description }}</p>
                        </div>

                        @if($item->remarks)
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Staff Remarks</label>
                            <p class="text-gray-600 italic bg-amber-50/50 p-3 rounded-lg border border-amber-100/50">"{{ $item->remarks }}"</p>
                        </div>
                        @endif
                    </div>

                    <div class="mt-12 pt-6 border-t border-gray-50 flex items-center justify-between">
                        <p class="text-xs text-gray-400 italic">Last modification: {{ $item->updated_at->diffForHumans() }}</p>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection