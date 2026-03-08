<?php

namespace App\Http\Controllers;

use App\Models\DriverViolation;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ViolationController extends Controller
{
    /**
     * Show the form for creating a violation, pre-filled with Report data.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $violations = DriverViolation::with(['driver', 'filer'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    // Search in the 'violation' text field
                    $q->where('violation', 'like', "%{$search}%")
                        ->orWhere('remarks', 'like', "%{$search}%")

                    // Search in the related 'drivers' table (username)
                        ->orWhereHas('driver', function ($driverQuery) use ($search) {
                            $driverQuery->where('username', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // This keeps the search parameter in pagination links

        return view('violation.index', compact('violations'));
    }

    public function show($id)
    {
        $violation = DriverViolation::with(['driver', 'filer', 'report'])
            ->findOrFail($id);

        return view('violation.show', compact('violation'));
    }

    public function create(Request $request)
    {
        // Find the report to link it
        $report = Report::with('driver')->findOrFail($request->report_id);

        return view('violation.create', compact('report'));
    }

    public function createNew(Request $request)
    {
        $drivers = User::where('role', 'driver')->orderBy('username')->get();

        return view('violation.create_new', compact('drivers'));
    }

    /**
     * Store the violation and link it back to the report.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_id' => 'required|exists:reports,id',
            'violation' => 'required|string|max:255',
            'suspension_days' => 'required|integer|min:0',
            'suspension_start_date' => 'nullable|date',
            'suspension_end_date' => 'nullable|date|after_or_equal:suspension_start_date',
            'remarks' => 'nullable|string',
        ]);

        // Use a DB Transaction to ensure both tables update or neither does
        DB::transaction(function () use ($validated) {
            $report = Report::findOrFail($validated['report_id']);

            // 1. Create the Violation record
            $violation = DriverViolation::create([
                'violation' => $validated['violation'],
                'driver_id' => $report->driver_id,
                'filed_by' => Auth::id(),
                'suspension_days' => $validated['suspension_days'],
                'suspension_start_date' => $validated['suspension_start_date'],
                'suspension_end_date' => $validated['suspension_end_date'],
                'remarks' => $validated['remarks'],
            ]);

            // 2. Update the Report status and link the violation ID
            $report->update([
                'status' => 'approved',
                'violation_id' => $violation->id,
                'reviewed_by' => Auth::id(),
            ]);
        });

        return redirect()->route('viewReport')
            ->with('success', 'Violation has been officially filed and the report approved.');
    }

    public function storeNewViolation(Request $request)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:users,id',
            'violation' => 'required|string|max:255',
            'suspension_days' => 'required|integer|min:0',
            'suspension_start_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        $days = $request->integer('suspension_days');
        $start = \Carbon\Carbon::parse($validated['suspension_start_date']);

        // Carbon now receives an integer as expected
        $end = $start->copy()->addDays($days);

        DriverViolation::create([
            'driver_id' => $validated['driver_id'],
            'violation' => $validated['violation'],
            'suspension_days' => $validated['suspension_days'],
            'suspension_start_date' => $start,
            'suspension_end_date' => $end,
            'remarks' => $validated['remarks'],
            'filed_by' => Auth::id(), // Set current admin as the filer
        ]);

        return redirect()->route('viewViolationList')->with('success', 'Violation recorded successfully.');
    }

    // Driver My Violation

    public function myViolations()
    {
        $violations = DriverViolation::where('driver_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('driver.violations.index', compact('violations'));
    }

    public function showMyViolation($id)
    {
        // Ensure the violation belongs to the authenticated driver
        $violation = DriverViolation::with(['filer', 'report'])
            ->where('driver_id', Auth::id())
            ->findOrFail($id);

        return view('driver.violations.show', compact('violation'));
    }
}
