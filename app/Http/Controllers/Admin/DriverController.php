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
    public function index(Request $request)
    {
        $search = $request->input('search');

        $drivers = User::where('role', 'driver')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    // Search User table
                    $q->where('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                      // Search Related DriverInformation table
                        ->orWhereHas('driverInformation', function ($subQuery) use ($search) {
                            $subQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('plate_number', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // Keeps search query in pagination links

        return view('admin.driver.index', compact('drivers'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $driverInfo = DriverInformation::where('user_id', $user->id)->firstOrFail();

        return view('admin.driver.edit', compact('user', 'driverInfo'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $driverInfo = DriverInformation::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'license_expiry_date' => 'nullable|date',
            'plate_number' => 'nullable|string|max:20',
        ]);

        // Update User Account
        $user->update([
            'username' => $validated['username'],
            'email' => $validated['email'],
        ]);

        // Update Driver Profile
        $driverInfo->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'license_expiry_date' => $validated['license_expiry_date'],
            'plate_number' => $validated['plate_number'],
        ]);

        return back()->with('success', 'Driver profile updated successfully.');
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);

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
