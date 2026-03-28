@extends('layouts.dashboard')

@section('content')
    <div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
        <div class="max-w-6xl mx-auto">
            <header class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Trip Fare</h1>
                        <p class="text-gray-500 mt-1">Manage system-wide pricing for trips, terminals, and hire services.</p>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('admin.fare.create') }}"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all shadow-sm flex items-center gap-2">
                            <x-tabler-plus class="w-4 h-4" />
                            Create New Fare
                        </a>
                    </div>
                </div>
            </header>

            {{-- Info Card for Active Fare --}}
            @php $activeFare = $fares->where('is_current', true)->first(); @endphp

            @if ($activeFare)
                <div class="mb-8 bg-indigo-900 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                    <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                        <div>
                            <span
                                class="text-indigo-200 text-xs font-bold uppercase tracking-widest text-indigo-100/60">Currently
                                Active Rate</span>
                            <h2 class="text-2xl font-bold mt-1 tracking-tight">{{ $activeFare->label }}</h2>
                        </div>
                        <div class="flex gap-8">
                            <div class="text-center">
                                <p class="text-indigo-300 text-xs uppercase font-semibold">Base Fare</p>
                                <p class="text-xl font-bold">₱{{ number_format($activeFare->trip_fare, 2) }}</p>
                            </div>
                            {{-- <div class="text-center">
                                <p class="text-indigo-300 text-xs uppercase font-semibold">Terminal</p>
                                <p class="text-xl font-bold">₱{{ number_format($activeFare->terminal_fare, 2) }}</p>
                            </div> --}}
                            <div class="text-center">
                                <p class="text-indigo-300 text-xs uppercase font-semibold">Special Trip</p>
                                <p class="text-xl font-bold">₱{{ number_format($activeFare->hire_fare, 2) }}</p>
                            </div>
                        </div>
                    </div>
                    {{-- Decorative background icon --}}
                    <x-tabler-receipt-2 class="absolute -right-4 -bottom-4 w-32 h-auto text-white/10 rotate-12" />
                </div>
            @else
                <div
                    class="mb-8 bg-amber-50 border-2 border-dashed border-amber-200 rounded-2xl p-8 text-center relative overflow-hidden">
                    <div class="relative z-10 flex flex-col items-center justify-center">
                        <div
                            class="w-16 h-16 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mb-4">
                            <x-tabler-alert-triangle class="w-10 h-10" />
                        </div>
                        <h2 class="text-xl font-bold text-amber-900">No Active Fare Description Found</h2>
                        <p class="text-amber-700 mt-2 max-w-md mx-auto">
                            Please create a new fare or <strong>activate</strong> an existing one from the list below to
                            enable.
                        </p>
                        <a href="{{ route('admin.fare.create') }}"
                            class="mt-4 inline-flex items-center gap-2 bg-amber-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-amber-700 transition-all shadow-lg shadow-amber-100">
                            <x-tabler-plus class="w-5 h-5" />
                            Setup New Fare
                        </a>
                    </div>

                    <x-tabler-coin-off class="absolute -right-4 -bottom-4 w-32 h-32 text-amber-200/30 -rotate-12" />
                </div>
            @endif

            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50/50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Description
                                    Label</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400 text-right">
                                    Base Fare</th>
                                {{-- <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400 text-right">
                                    Terminal</th> --}}
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400 text-right">
                                    Special Trip</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400 text-center">
                                    Status</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($fares as $fare)
                                <tr
                                    class="hover:bg-gray-50/30 transition-colors {{ $fare->is_current ? 'bg-indigo-50/20' : '' }}">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-lg {{ $fare->is_current ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center border border-gray-100">
                                                <x-tabler-coin class="h-5 w-5" />
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-gray-900">{{ $fare->label }}</div>
                                                <div class="text-[10px] text-gray-400 uppercase tracking-tighter">ID:
                                                    #{{ str_pad($fare->id, 4, '0', STR_PAD_LEFT) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right font-medium text-gray-700">
                                        ₱{{ number_format($fare->trip_fare, 2) }}
                                    </td>
                                    {{-- <td class="px-6 py-4 text-right font-medium text-gray-700">
                                        ₱{{ number_format($fare->terminal_fare, 2) }}
                                    </td> --}}
                                    <td class="px-6 py-4 text-right font-medium text-gray-700">
                                        ₱{{ number_format($fare->hire_fare, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($fare->is_current)
                                            <span
                                                class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-green-100 text-green-700">
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-400">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center gap-4">
                                            <a href="{{ route('admin.fare.edit', $fare->id) }}"
                                                class="text-indigo-600 font-bold hover:underline">Edit</a>

                                            @if (!$fare->is_current)
                                                <form action="{{ route('admin.fare.update', $fare->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" name="is_current" value="1">
                                                    <button type="submit"
                                                        class="text-gray-900 font-bold hover:text-indigo-600 transition-colors">Activate</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <x-tabler-receipt-off class="h-12 w-12 text-gray-200 mb-4" />
                                            <p class="text-gray-500 font-medium">No fare descriptions found.</p>
                                            <p class="text-xs text-gray-400 mt-1">Create your first pricing rule to get
                                                started.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($fares->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray100">
                        {{ $fares->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection-
