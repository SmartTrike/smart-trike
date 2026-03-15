@extends('layouts.dashboard')

@section('content')
    <div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
        <div class="max-w-6xl mx-auto">

            <header class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Manage Dispatchers</h1>
                        <p class="text-gray-500 mt-1">Create and manage accounts for terminal dispatchers.</p>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('admin.dispatchers.create') }}"
                            class="px-4 py-2 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-black transition-all shadow-sm">
                            Add New Dispatcher
                        </a>
                    </div>
                </div>
            </header>

            <div class="mb-6">
                <form action="{{ route('admin.dispatchers.index') }}" method="GET" class="flex gap-2">
                    <div class="relative flex-1 max-w-md">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <x-heroicon-o-magnifying-glass class="w-5 h-5 text-gray-400" />
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by username or email..."
                            class="block w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-gray-900 text-sm transition-all">
                    </div>
                    <button type="submit"
                        class="px-6 py-2 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-black transition-all">
                        Filter
                    </button>

                    @if (request('search'))
                        <a href="{{ route('admin.dispatchers.index') }}"
                            class="px-4 py-2 bg-gray-100 text-gray-600 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50/50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">
                                        Dispatcher Profile</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Email
                                        Address</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Date
                                        Joined</th>
                                    <th
                                        class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400 text-right">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($dispatchers as $dispatcher)
                                    <tr class="hover:bg-gray-50/30 transition-colors group">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-10 h-10 rounded-lg bg-gray-900 flex items-center justify-center text-white text-xs font-black shadow-inner">
                                                    {{ strtoupper(substr($dispatcher->username, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <div class="text-sm font-bold text-gray-900">{{ $dispatcher->username }}
                                                    </div>
                                                    <div class="text-2xs text-gray-400 uppercase tracking-tighter">ID:
                                                        #{{ $dispatcher->id }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-600 font-medium">{{ $dispatcher->email }}</div>
                                        </td>



                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-700 font-medium">
                                                {{ $dispatcher->created_at->format('M d, Y') }}</div>
                                            <div class="text-2xs text-gray-400 uppercase">
                                                {{ $dispatcher->created_at->format('h:i A') }}</div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="flex items-center justify-end gap-3">
                                                <a href="{{ route('admin.dispatchers.edit', $dispatcher->id) }}"
                                                    class="text-xs font-black uppercase tracking-widest text-blue-600 hover:text-blue-800 transition-colors">
                                                    Edit
                                                </a>
                                                <span class="text-gray-200">|</span>
                                                <!-- <form action="" method="POST" onsubmit="return confirm('Delete this dispatcher account?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-black uppercase tracking-widest text-red-500 hover:text-red-700 transition-colors">
                                                Delete
                                            </button>
                                        </form> -->
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-20 text-center">
                                            <div class="flex flex-col items-center">
                                                <x-heroicon-o-users class="w-12 h-12 text-gray-200 mb-4" />
                                                <p class="text-gray-500 font-medium">No dispatchers found.</p>
                                                <p class="text-xs text-gray-400 mt-1">Try adjusting your search filters or
                                                    add a new account.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($dispatchers->hasPages())
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                            {{ $dispatchers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection
