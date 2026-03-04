<?php

namespace App\Http\Controllers;

use App\Models\DriverViolation;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ViolationController extends Controller
{
   /**
     * Show the form for creating a violation, pre-filled with Report data.
     */
    public function create(Request $request)
    {
        // Find the report to link it
        $report = Report::with('driver')->findOrFail($request->report_id);

        return view('violation.create', compact('report'));
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
        DB::transaction(function () use ($validated, $request) {
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

        return redirect()->route('viewReportViolation')
                         ->with('success', 'Violation has been officially filed and the report approved.');
    }
}
