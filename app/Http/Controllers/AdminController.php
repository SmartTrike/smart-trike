<?php

namespace App\Http\Controllers;

use App\Models\DriverInformation;
use App\Models\DriverQueue;
use App\Models\Ride;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\CodeCoverage\Driver\Driver;

class AdminController extends Controller
{
    public function index()
    {
        // Define today's date range for querying
        $today = now()->startOfDay();
        $endOfDay = now()->endOfDay();

        try {
            // Fetch counts with a single query per model, using a date range
            $activeQueueCount = DriverQueue::where('status', 'waiting')
                ->whereBetween('created_at', [$today, $endOfDay])
                ->count();

            $onRideCount = Ride::where('status', 'ongoing')
                ->whereBetween('dispatch_at', [$today, $endOfDay])
                ->count();

            $completedCount = Ride::where('status', 'completed')
                ->whereBetween('dispatch_at', [$today, $endOfDay])
                ->count();

            $cancelledCount = Ride::where('status', 'cancelled')
                ->whereBetween('dispatch_at', [$today, $endOfDay])
                ->count();

            // Fetch ongoing rides with the associated driver information
            $ongoingRides = Ride::where('status', 'ongoing')
                ->whereBetween('dispatch_at', [$today, $endOfDay])
                ->with('driver')  // Assuming you have a relationship defined in the Ride model
                ->paginate(10);



            $currentQueueDriver = DriverQueue::where('status', 'waiting')
                ->orderBy('created_at', 'asc') // Assuming the first driver is the one with the earliest created_at
                ->first();

            // Fetch details for the current driver
            $driverDetails = null;
            if ($currentQueueDriver) {
                $driverDetails = DriverInformation::where('user_id', $currentQueueDriver->driver_id)->first();
            }


            // Return the view with the data
            return view('admin.dashboard', compact('activeQueueCount', 'onRideCount', 'completedCount', 'cancelledCount', 'ongoingRides', 'currentQueueDriver', 'driverDetails'));
        } catch (\Exception $e) {
            // Log the error for debugging and alerting
            Log::error('Error fetching dashboard data: ' . $e->getMessage());

            // Optionally, return default values with an error message
            return view('admin.dashboard', [
                'activeQueueCount' => 0,
                'onRideCount' => 0,
                'completedCount' => 0,
                'cancelledCount' => 0,
                'ongoingRides' => [],
                'error' => 'There was an error loading data. Please try again later.'
            ]);
        }
    }
}
