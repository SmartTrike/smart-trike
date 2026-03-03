@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
    <div class="max-w-6xl mx-auto">
        <header class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Lost and Found Items</h1>
                    <p class="text-gray-500 mt-1">View the items you have reported or found.</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('createLostAndFound') }}" class="px-4 py-2 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-black transition-all">Report New Item</a>
                </div>
            </div>
        </header>

        <div class="mb-6">
            <form action="" method="GET" class="flex gap-2">
                <div class="relative flex-1 max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-heroicon-o-magnifying-glass class="w-5 h-5 text-gray-400" />
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search..."
                        class="block w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-gray-900 text-sm">
                </div>
                <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-black transition-all">
                    Filter
                </button>
            </form>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Item Description</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400 text-center">Reported By</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Status</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Date Reported</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($items as $item)
                        <tr class="hover:bg-gray-50/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($item->image_path)
                                    <img src="{{ asset('storage/' . $item->image_path) }}" class="w-10 h-10 rounded-lg object-cover border border-gray-100">
                                    @else
                                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                        <x-heroicon-o-camera class="w-5 h-5" />
                                    </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-bold text-gray-900 line-clamp-1">{{ $item->item_name }}</div>
                                        <div class="text-xs text-gray-500">{{ ucfirst($item->type) }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-50 text-gray-600 border border-gray-100">
                                    {{ $item->reporter->username ?? 'Unknown' }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                @php
                                $statusColors = [
                                'reported' => 'bg-blue-100 text-blue-700',
                                'claimed' => 'bg-amber-100 text-amber-700',
                                'returned' => 'bg-green-100 text-green-700',
                                'disposed' => 'bg-gray-100 text-gray-600',
                                ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-2xs font-bold uppercase tracking-wider {{ $statusColors[$item->status] ?? 'bg-gray-100' }}">
                                    {{ $item->status }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ $item->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-400">{{ $item->created_at->format('h:i A') }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('showLostAndFound', $item->id) }}" class="text-gray-900 font-bold hover:underline">View and Update</a>


                                </div>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($items->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $items->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection