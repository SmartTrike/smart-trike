<?php

namespace App\Http\Controllers\Dispatcher;

use App\Http\Controllers\Controller;
use App\Models\DispatcherInformation;
use App\Models\DriverInformation;
use App\Models\DriverQueue;
use App\Models\FareSetting;
use App\Models\LostItem;
use App\Models\Ride;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class DispatcherController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
  

        $today = now()->startOfDay();
        $endOfDay = now()->endOfDay();

        try {
            $firstQueueDriver = DriverQueue::where('status', 'waiting')
                ->orderBy('created_at', 'asc') // First in queue
                ->first();

            $activeQueueCount  = DriverQueue::where('status', 'waiting')
                ->whereBetween('created_at', [$today, $endOfDay])
                ->count();
            $ongoingRides = Ride::where('status', 'ongoing')->paginate(10);


            $onRideCount = Ride::where('status', 'ongoing')
                ->whereBetween('dispatch_at', [$today, $endOfDay])
                ->count();


            $completedCount = Ride::where('status', 'completed')
                ->whereBetween('dispatch_at', [$today, $endOfDay])
                ->count();

            $lostAndFoundCount = LostItem::where('status', 'reported')->count();

            $currentQueueDriver = DriverQueue::where('status', 'waiting')
                ->orderBy('created_at', 'asc') // Assuming the first driver is the one with the earliest created_at
                ->first();

              $fare = FareSetting::where('is_current', true)->first();

            $driverDetails = null;
            if ($firstQueueDriver) {
                $driverDetails = DriverInformation::where('user_id', $firstQueueDriver->driver_id)->first();
            }

            return view('dispatcher.dashboard', compact(
                'activeQueueCount',
                'onRideCount',
                'completedCount',
                'lostAndFoundCount',
                'currentQueueDriver',
                'driverDetails',
                'ongoingRides',
                'fare'
            ));
        } catch (\Exception $e) {
            Log::error('Error fetching dashboard data: ' . $e->getMessage());
        }
    }

     public function editProfile()
    {
        $user = Auth::user();
        // Eager load the information
        $dispatcherInfo = DispatcherInformation::where('user_id', $user->id)->firstOrFail();

        return view('dispatcher.profile', compact('user', 'dispatcherInfo'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $dispatcherInfo = DispatcherInformation::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update(['email' => $request->email]);
        $dispatcherInfo->update($request->only(['first_name', 'last_name', 'contact_number', 'address']));

        return back()->with('success', 'Your profile has been updated successfully.');
    }


public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => ['required'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ], [
        // Current password
        'current_password.required' => 'Please enter your current password.',

        // New password
        'password.required' => 'Please enter a new password.',
        'password.min' => 'Your new password must be at least 8 characters.',
        'password.confirmed' => 'The new password confirmation does not match.',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors([
            'current_password' => 'Your current password is incorrect.'
        ])->withInput();
    }

    $user->update([
        'password' => Hash::make($request->password),
    ]);

    return back()->with('success', 'Password updated successfully.');
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
