<?php

namespace App\Http\Controllers;

use App\Models\FareSetting;
use Illuminate\Http\Request;

class FareSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all fares, ordered so the current one is at the top
        $fares = FareSetting::orderBy('is_current', 'desc')
            ->latest()
            ->paginate(10);

        return view('fare.index', compact('fares'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fare.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'trip_fare' => 'required|numeric|min:0|max:999999',
            // 'terminal_fare' => 'required|numeric|min:0|max:999999',
            'hire_fare' => 'required|numeric|min:0|max:999999',
            'is_current' => 'nullable|boolean',
        ]);

        // 2. Data Preparation
        // Checkboxes only send a value if they are checked.
        // If it's missing from the request, we default it to false.
        $data = $request->all();
        $data['is_current'] = $request->has('is_current');

        // 3. Execution
        // Because of the 'booted' static::saving method we added to the Model earlier,
        // setting 'is_current' to true here will automatically set all others to false.
        FareSetting::create($data);

        // 4. Response
        return redirect()->route('admin.fare.index')
            ->with('success', 'New fare description "'.$validated['label'].'" has been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FareSetting $fareSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $fare = FareSetting::findOrFail($id);

        return view('fare.edit', compact('fare'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $id)
    // {
    //     // 1. Find the specific fare
    //     $fare = FareSetting::findOrFail($id);

    //     // 2. Validate everything
    //     $request->validate([
    //         'label' => 'required|string|max:255',
    //         'trip_fare' => 'required|numeric|min:0',
    //         'terminal_fare' => 'required|numeric|min:0',
    //         'hire_fare' => 'required|numeric|min:0',
    //     ]);

    //     // 3. Check if the toggle was switched on
    //     // Checkboxes only exist in $request if they are checked
    //     $wantsToBeCurrent = $request->has('is_current');

    //     if ($wantsToBeCurrent) {
    //         FareSetting::where('id', '!=', $id)
    //             ->where('is_current', true)
    //             ->update(['is_current' => false]);
    //     }

    //     // 4. Update and Save
    //     $fare->label = $request->label;
    //     $fare->trip_fare = $request->trip_fare;
    //     $fare->terminal_fare = $request->terminal_fare;
    //     $fare->hire_fare = $request->hire_fare;
    //     $fare->is_current = $wantsToBeCurrent;

    //     $fare->save();

    //     return redirect()->route('admin.fare.index')
    //         ->with('success', 'Fare settings updated successfully.');
    // }

    public function update(Request $request, $id)
    {
        $fare = FareSetting::findOrFail($id);

        // 1. FAST UPDATE DETECTOR:
        // If we only have 'is_current' and no 'label' in the request, it's from the Index button.
        if ($request->has('is_current') && ! $request->has('label')) {

            // Deactivate all others
            FareSetting::where('is_current', true)->update(['is_current' => false]);

            // Activate this one
            $fare->update(['is_current' => true]);

            return back()->with('success', "Fare structure '{$fare->label}' is now ACTIVE.");
        }

        // 2. FULL UPDATE:
        // If 'label' exists, we are coming from the Edit Form.
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'trip_fare' => 'required|numeric|min:0',
            'hire_fare' => 'required|numeric|min:0',
        ]);

        $wantsToBeCurrent = $request->has('is_current');

        if ($wantsToBeCurrent) {
            FareSetting::where('id', '!=', $id)->update(['is_current' => false]);
        }

        $fare->update(array_merge($validated, [
            'is_current' => $wantsToBeCurrent,
        ]));

        return redirect()->route('admin.fare.index')
            ->with('success', 'Fare settings updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FareSetting $fareSetting)
    {
        //
    }
}
