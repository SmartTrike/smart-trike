<?php

namespace App\Http\Controllers;

use App\Models\DriverInformation;
use App\Models\DriverQueue;
use App\Models\Ride;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DispatcherController extends Controller
{
    //
    public function dispatchDriver(Request $request)
    {
        // 1. Validate (Note: Ensure the 'status' logic aligns with your business flow)
        $validated = $request->validate([
            'driver_id'       => 'required|exists:driver_information,user_id',
            'passenger_count' => 'required|integer|min:1',
            'remarks'         => 'nullable|string',
            'status'          => 'required|in:ongoing,completed,cancelled',
        ]);

        // 2. Fetch the driver info and queue entry simultaneously
        // Use the validated driver_id to avoid "null" errors
        $driverQueueEntry = DriverQueue::where('driver_id', $validated['driver_id'])
            ->where('status', 'waiting')
            ->first();

        if (!$driverQueueEntry) {
            return response()->json(['message' => 'Driver not in queue or already dispatched'], 404);
        }


        // Update Queue: change status
        $driverQueueEntry->update([
            'status'         => 'on_ride',
        ]);

        // Create Ride
        Ride::create([
            'driver_id'       => $validated['driver_id'],
            'dispatcher_id'   => Auth::id(),
            'passenger_count' => $validated['passenger_count'],
            'dispatch_at'     => now(),
            'remarks'         => $validated['remarks'],
            'status'          => $validated['status'],
        ]);

        return response()->json(['message' => 'Driver dispatched successfully']);
    }
}
