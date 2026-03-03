<?php

namespace App\Http\Controllers\Dispatcher;

use App\Http\Controllers\Controller;
use App\Models\DriverInformation;
use App\Models\DriverQueue;
use App\Models\LostItem;
use App\Models\Ride;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DispatcherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // // Fetch the first driver in the queue (Number 1)
        // $firstQueueDriver = DriverQueue::where('status', 'waiting')
        //     ->orderBy('created_at', 'asc') // First in queue
        //     ->first();

        // // Fetch other drivers in the queue
        // $queuedDrivers = DriverQueue::where('status', 'waiting')
        //     ->orderBy('created_at', 'asc') // Sort by queue position
        //     ->get();

        // // Fetch driver details for the first queue driver
        // $driverDetails = null;
        // if ($firstQueueDriver) {
        //     $driverDetails = DriverInformation::where('user_id', $firstQueueDriver->driver_id)->first();
        // }

        $today = now()->startOfDay();
        $endOfDay = now()->endOfDay();

        try {
            $firstQueueDriver = DriverQueue::where('status', 'waiting')
                ->orderBy('created_at', 'asc') // First in queue
                ->first();

            $activeQueueCount  = DriverQueue::where('status', 'waiting')
                ->whereBetween('created_at', [$today, $endOfDay])
                ->count();
            $ongoingRides = Ride::paginate(10);


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
                'ongoingRides'
            ));
        } catch (\Exception $e) {
            Log::error('Error fetching dashboard data: ' . $e->getMessage());
        }
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
