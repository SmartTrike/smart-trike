<?php

namespace App\Http\Controllers;

use App\Models\DriverInformation;
use App\Models\DriverQueue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $driverInfo = $user->driverInfo;

        // 1. Get the current user's waiting record for today
        $myQueueRecord = DriverQueue::where('driver_id', $user->id)
            ->where('status', 'waiting')
            ->whereDate('created_at', now()->today())
            ->first();

        $queuePosition = null;

        if ($myQueueRecord) {
            // 2. CALCULATE POSITION: 
            // Count how many drivers checked in BEFORE this driver today and are still 'waiting'
            $queuePosition = DriverQueue::where('status', 'waiting')
                ->whereDate('created_at', now()->today())
                ->where('created_at', '<', $myQueueRecord->created_at)
                ->count() + 1;
        }

        return view('driver.home', compact('driverInfo', 'queuePosition'));
    }

    public function checkIn(Request $request)
    {
        $user = Auth::user();
        $today = now()->today();

        // 1. Prevent duplicate check-ins for the same day
        $alreadyInQueueToday = DriverQueue::where('driver_id', $user->id)
            ->where('status', 'waiting')
            ->whereDate('created_at', $today)
            ->exists();

        if ($alreadyInQueueToday) {
            return redirect()->back()->with('error', 'You are already in the queue.');
        }

        // 2. Simple Create: The timestamp handles the "position" logic automatically
        DriverQueue::create([
            'driver_id' => $user->id,
            'status'    => 'waiting',
        ]);

        return redirect()->back()->with('success', "Checked in successfully!");
    }
}
