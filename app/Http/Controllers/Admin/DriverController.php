<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DriverInformation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = User::where('role', 'driver')->paginate(10);
        return view('admin.driver.index', compact('drivers'));
    }

    public function edit($id)
    {
        // $id is the User ID
        $user = User::findOrFail($id);
        $driverInfo = DriverInformation::where('user_id', $user->id)->firstOrFail();

        return view('admin.driver.edit', compact('driverInfo', 'user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $driverInfo = DriverInformation::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => ['required', 'string', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'license_expiry_date' => 'nullable|date',
            'plate_number' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $user->update([
            'username' => $validated['username'],
            'email' => $validated['email'],
        ]);

        $driverInfo->update($validated);

        return back()->with('success', 'Driver information updated.');
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Driver password reset successfully.');
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


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
