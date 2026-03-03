<?php

namespace App\Http\Controllers;

use App\Models\DriverInformation;
use App\Models\DriverQueue;
use App\Models\LostItem;
use App\Models\Ride;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

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

    public function viewProfile()
    {
        $user = Auth::user();
        $driverInfo = $user->driverInfo;

        return view('driver.profile', compact('driverInfo'));
    }

    public function updatePhoto(Request $request)
    {
        // 1. Validation: 'max:2048' is exactly 2MB (2048 KB)
        $request->validate([
            'profile_photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,gif',
                'max:2048', // 2048 KB = 2MB
            ],
        ]);

        $user = Auth::user();
        $driverInfo = $user->driverInfo;

        if ($request->hasFile('profile_photo')) {
            // 2. Delete the old photo if it exists
            if ($driverInfo->profile_photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($driverInfo->profile_photo);
            }

            // 3. Store the new photo
            $path = $request->file('profile_photo')->store('profile_photos', 'public');

            // 4. Save to Database
            $driverInfo->update([
                'profile_photo' => $path
            ]);
        }

        return back()->with('success', 'Profile photo updated successfully.');
    }

    public function updateInformation(Request $request)
    {
        $user = Auth::user();
        $driverInfo = $user->driverInfo;

        // 1. Validation for all Driver Information fields
        $validated = $request->validate([
            'first_name'            => 'required|string|max:50',
            'middle_name'           => 'nullable|string|max:50',
            'last_name'             => 'required|string|max:50',
            'suffix'                => 'nullable|string|max:10',
            'contact_number'        => 'required|string|max:20',
            'address'               => 'required|string|max:255',
            'birthdate'             => 'required|date|before:today',
            'license_number'        => 'required|string|max:50|unique:driver_information,license_number,' . $driverInfo->id,
            'plate_number'          => 'required|string|max:20|unique:driver_information,plate_number,' . $driverInfo->id,
            'tricycle_body_number'  => 'required|string|max:20',
            'model'                 => 'nullable|string|max:50',
        ]);

        // 2. Update the record
        $driverInfo->update($validated);

        return back()->with('success', 'Profile information updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        // 1. Validation
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // 2. Update Password
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }


    public function checkIn(Request $request)
    {
        $user = Auth::user();
        $today = now()->today();
        $now = now();
        // 1. Prevent duplicate check-ins for the same day
        $alreadyInQueueToday = DriverQueue::where('driver_id', $user->id)
            ->where('status', 'waiting')
            ->whereDate('created_at', $now->toDateString())
            ->exists();

        if ($alreadyInQueueToday) {
            return redirect()->back()->with('error', 'You are already in the queue.');
        }

        // 2. Simple Create: The timestamp handles the "position" logic automatically
        DriverQueue::create([
            'driver_id' => $user->id,
            'status'    => 'waiting',
            'created_at' => $now,
        ]);

        return redirect()->back()->with('success', "Checked in successfully!");
    }


    public function tripHistory(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');

        $trips = Ride::where('driver_id', $user->id)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('status', 'like', "%{$search}%")
                        ->orWhere('id', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('driver.trip-history', compact('trips'));
    }


}
