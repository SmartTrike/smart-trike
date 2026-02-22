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
            <table class="table-auto w-full mt-4" id="dispatchers-table">
                <thead class="bg-neutral-secondary-soft border-b border-default">
                    <tr>
                        <th class="px-6 py-3 text-left">First Name</th>
                        <th class="px-6 py-3 text-left">Last Name</th>
                        <th class="px-6 py-3 text-left">Contact Number</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </section>

</div>

<!-- Include DataTables JS -->
@push('scripts')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dispatchers-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.dispatchers.data') }}",
                type: 'GET',
                dataSrc: 'data' 
            },
            columns: [{
                    data: 'first_name',
                    name: 'first_name'
                },
                {
                    data: 'last_name',
                    name: 'last_name'
                },
                {
                    data: 'contact_number',
                    name: 'contact_number'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
@endpush

@endsection