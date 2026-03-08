<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        $reports = Report::with(['driver', 'reporter'])
            ->when($searchTerm, function ($query, $searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    // Search in the description
                    $q->where('description', 'like', "%{$searchTerm}%")
                        // Search in the Driver's name
                        ->orWhereHas('driver', function ($dq) use ($searchTerm) {
                            $dq->where('usernam', 'like', "%{$searchTerm}%");
                        })
                        // Search in the Reporter's name
                        ->orWhereHas('reporter', function ($rq) use ($searchTerm) {
                            $rq->where('usernam', 'like', "%{$searchTerm}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // This keeps the search term in pagination links

        return view('report.index', compact('reports'));
    }

    public function createNewReport()
    {
        // Safety: Ensure we only get active drivers and handle empty states
        $drivers = User::where('role', 'driver')
            ->orderBy('username', 'asc')
            ->get();

        return view('report.create_report', compact('drivers'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validated = $request->validate([
            'driver_id' => 'required|exists:users,id',
            'description' => 'required|string|min:10',
            'event_date' => 'required|date|before_or_equal:now',
            'remarks' => 'nullable|string|max:1000',
            'evidence_image_path' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Max 5MB
        ]);

        try {
            $path = null;
            if ($request->hasFile('evidence_image_path')) {
                $path = $request->file('evidence_image_path')->store('reports', 'public');
            }

            // 3. Create the Database Record
            Report::create([
                'description'   => $validated['description'],
                'status'        => 'reported', // Default status from migration
                'reported_by'   => Auth::id(), // The logged-in user filing the report
                'driver_id'     => $validated['driver_id'],
                'event_date'    => $validated['event_date'],
                'remarks'       => $validated['remarks'] ?? null,
                'evidence_image_path' => $path,
            ]);

            return redirect()->route('viewReport')
                ->with('success', 'Incident report submitted successfully.');


        } catch (\Exception $e) {

            if (isset($path)) {
                Storage::disk('public')->delete($path);
            }

            return back()->withInput()
                ->with('error', 'An error occurred while saving the report. Please try again.');
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Eager load driver and reporter to prevent N+1 queries
        $report = Report::with(['driver', 'reporter'])->findOrFail($id);

        return view('report.show_report', compact('report'));
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
