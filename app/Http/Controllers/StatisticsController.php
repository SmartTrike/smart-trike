<?php

namespace App\Http\Controllers;

use App\Models\DriverViolation;
use App\Models\Report;
use App\Models\Ride;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        $date = Carbon::createFromDate($year, $month, 1);

        // --- 1. Quick Totals (Filtered by Month/Year) ---
        $stats = [
            'total_rides' => Ride::whereYear('dispatch_at', $year)->whereMonth('dispatch_at', $month)->count(),
            'total_violations' => DriverViolation::whereYear('created_at', $year)->whereMonth('created_at', $month)->count(),
            'total_reports' => Report::whereYear('event_date', $year)->whereMonth('event_date', $month)->count(),
            'active_drivers' => User::where('role', 'driver')->count(),
        ];

        // --- 2. Chart Data: Rides per Day ---
        $ridesPerDay = Ride::select(DB::raw('DATE(dispatch_at) as date'), DB::raw('count(*) as count'))
            ->whereYear('dispatch_at', $year)
            ->whereMonth('dispatch_at', $month)
            ->groupBy('date')
            ->pluck('count', 'date');

        // --- 3. Chart Data: Violation Types Distribution ---
        $violationTypes = DriverViolation::select('violation', DB::raw('count(*) as count'))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('violation')
            ->pluck('count', 'violation');

        return view('admin.statistics', compact('stats', 'ridesPerDay', 'violationTypes', 'month', 'year'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
