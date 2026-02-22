@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-white md:bg-gray-50/30 p-4 lg:p-10 overflow-y-auto">

    <!-- Header Section -->
    <header class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Manage Dispatchers</h1>
    </header>

    <!-- Add New Dispatcher Button -->
    <div class="mb-6">
        <a href="{{ route('admin.dispatchers.create') }}" class="px-6 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600">
            Add New Dispatcher
        </a>
    </div>

    <!-- Dispatcher DataTable -->
    <section>
        <div class="bg-white p-6  shadow-xs border border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">All Dispatchers</h2>
            <!-- {{ $dataTable->table() }} -->
        </div>
    </section>

</div>

<!-- @push('scripts')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush -->

@endsection