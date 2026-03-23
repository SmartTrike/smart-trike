<?php

namespace App\Http\Controllers;

use App\Models\DriverQueue;
use App\Models\DriverViolation;
use App\Models\Ride;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = now()->toDateString();

        // 1. Check for Active Suspension
        $activeViolation = DriverViolation::where('driver_id', $user->id)
            ->whereDate('suspension_start_date', '<=', $today)
            ->whereDate('suspension_end_date', '>=', $today)
            ->first();

        // If suspended, return a restricted view and skip queue/ride logic
        if ($activeViolation) {
            return view('driver.suspended', compact('activeViolation'));
        }

        // 2. Original Logic (only runs if NOT suspended)
        $currentRide = Ride::where('driver_id', $user->id)
            ->where('status', 'ongoing')
            ->first();

        $queuePosition = null;
        $onRide = $currentRide ? true : false;

        if (! $onRide) {
            $myQueueRecord = DriverQueue::where('driver_id', $user->id)
                ->where('status', 'waiting')
                ->whereDate('created_at', now()->today())
                ->first();

            if ($myQueueRecord) {
                $queuePosition = DriverQueue::where('status', 'waiting')
                    ->whereDate('created_at', now()->today())
                    ->where('created_at', '<', $myQueueRecord->created_at)
                    ->count() + 1;
            }
        }

        $driverInfo = $user->driverInfo;

        return view('driver.home', compact('driverInfo', 'queuePosition', 'onRide', 'currentRide'));
    }

    public function completeRide(Request $request, $id)
    {
        $ride = Ride::findOrFail($id);

        // 1. Update the Ride status
        $ride->update([
            'status' => 'completed',
            'returned_at' => now(),
        ]);

        DriverQueue::where('driver_id', $ride->driver_id)
            ->where('status', 'on_ride')
            ->delete();

        return redirect()->back()->with('success', 'Ride completed successfully!');
    }

    public function viewProfile()
    {
        $user = Auth::user();
        $driverInfo = $user->driverInfo;

        return view('driver.profile', compact('driverInfo'));
    }

    public function updatePhoto(Request $request)
    {
        // 1. Validation (2MB limit)
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $user = Auth::user();
        $driverInfo = $user->driverInfo;
        $newPublicId = null;

        try {
            if ($request->hasFile('profile_photo')) {

                // 2. Upload the new photo to Cloudinary first
                // We use a specific 'profiles' folder
                $newPublicId = Storage::disk('cloudinary')->put('profiles', $request->file('profile_photo'));

                if (! $newPublicId) {
                    throw new \Exception('Failed to upload image to Cloudinary.');
                }

                // 3. Delete the old photo if it exists
                if ($driverInfo->profile_photo) {
                    // This works for both local paths and Cloudinary Public IDs
                    // as long as the 'cloudinary' disk is specified.
                    Storage::disk('cloudinary')->delete($driverInfo->profile_photo);
                }

                // 4. Update the Database with the new Public ID
                $driverInfo->update([
                    'profile_photo' => $newPublicId,
                ]);
            }

            return back()->with('success', 'Profile photo updated successfully.');

        } catch (\Exception $e) {
            Log::error('Profile Photo Update Error: '.$e->getMessage());

            // Cleanup: If the DB update failed, delete the newly uploaded image
            if ($newPublicId) {
                Storage::disk('cloudinary')->delete($newPublicId);
            }

            return back()->with('error', 'Could not update photo: '.$e->getMessage());
        }
    }

    public function updateInformation(Request $request)
    {
        $user = Auth::user();
        $driverInfo = $user->driverInfo;

        // 1. Validation for all Driver Information fields
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'suffix' => 'nullable|string|max:10',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'birthdate' => 'required|date|before:today',
            'license_expiry_date' => 'required|date,'.$driverInfo->id,
            'plate_number' => 'required|string|max:20|unique:driver_information,plate_number,'.$driverInfo->id,
            'tricycle_body_number' => 'required|string|max:20',
            'model' => 'nullable|string|max:50',
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
            'status' => 'waiting',
            'created_at' => $now,
        ]);

        return redirect()->back()->with('success', 'Checked in successfully!');
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
