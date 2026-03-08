@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50/30 p-4 lg:p-10">
    <div class=" mx-auto">
        <header class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">System Statistics</h1>
                <p class="text-gray-500">Overview of terminal performance and driver conduct.</p>
            </div>

            {{-- Month/Year Filter --}}
            <form action="{{ route('admin.statistics') }}" method="GET" class="flex gap-2">
                <select name="month" class="rounded-xl border-gray-200 text-sm">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>
                    @endforeach
                </select>
                <select name="year" class="rounded-xl border-gray-200 text-sm">
                    @foreach(range(now()->year, now()->year - 5) as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded-xl text-sm font-bold">Filter</button>
            </form>
        </header>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Rides</p>
                <p class="text-2xl font-black text-gray-900">{{ number_format($stats['total_rides']) }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Violations</p>
                <p class="text-2xl font-black text-red-600">{{ number_format($stats['total_violations']) }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Incident Reports</p>
                <p class="text-2xl font-black text-orange-500">{{ number_format($stats['total_reports']) }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Registered Drivers</p>
                <p class="text-2xl font-black text-blue-600">{{ number_format($stats['active_drivers']) }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Ride Activity Chart --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="font-bold text-gray-900 mb-4">Ride Activity (Daily)</h3>
                <canvas id="rideChart" height="200"></canvas>
            </div>

            {{-- Violation Distribution Chart --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="font-bold text-gray-900 mb-4">Common Violations</h3>
                <canvas id="violationChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Ride Activity Data
    const rideCtx = document.getElementById('rideChart').getContext('2d');
    new Chart(rideCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($ridesPerDay->keys()) !!},
            datasets: [{
                label: 'Rides',
                data: {!! json_encode($ridesPerDay->values()) !!},
                borderColor: '#111827',
                backgroundColor: 'rgba(17, 24, 39, 0.1)',
                fill: true,
                tension: 0.4
            }]
        }
    });

    // Violation Chart Data
    const violationCtx = document.getElementById('violationChart').getContext('2d');
    new Chart(violationCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($violationTypes->keys()) !!},
            datasets: [{
                data: {!! json_encode($violationTypes->values()) !!},
                backgroundColor: ['#ef4444', '#f97316', '#f59e0b', '#84cc16', '#06b6d4']
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endsection