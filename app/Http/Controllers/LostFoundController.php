<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LostFoundController extends Controller
{


    // // Lost and Found
    // public function lostAndFound()
    // {
    //     $items = LostItem::where('reported_by', Auth::user()->username)
    //         ->paginate(10);
    //     return view('driver.lost_and_found', compact('items'));
    // }

    // // Show the form for creating a new lost and found item
    // public function createLostAndFound()
    // {
    //     return view('driver.create_lost_and_found');
    // }

    // // Store the newly created lost and found item
    // public function storeLostAndFound(Request $request)
    // {
    //     $request->validate([
    //         'description' => 'required|string|max:255',
    //         'status' => 'required|in:lost,found',
    //         'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    //     ]);

    //     $lostAndFoundItem = new LostItem();
    //     $lostAndFoundItem->description = $request->description;
    //     $lostAndFoundItem->status = $request->status;
    //     $lostAndFoundItem->reported_by = Auth::user()->username;

    //     if ($request->hasFile('image')) {
    //         $lostAndFoundItem->image = $request->file('image')->store('lost_and_found_images', 'public');
    //     }

    //     $lostAndFoundItem->save();

    //     return redirect()->route('driver.lostAndFound')->with('success', 'Item reported successfully.');
    // }

    // // View individual item details (optional)
    // public function viewLostAndFoundItem($id)
    // {
    //     $item = LostItem::findOrFail($id);
    //     return view('driver.view_lost_and_found_item', compact('item'));
    // }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ensure the 'reporter' relationship is eager-loaded
        $items = LostItem::with('reporter') // Eager load the 'reporter' relationship
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Return the view with paginated and sorted items
        return view('lostFound.lost_and_found', compact('items'));
    }

    public function createLostAndFound(Request $request)
    {
        return view('lostFound.create_lost_and_found');
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
        // Validate the input fields
        $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'type' => 'required|in:lost,found',

            'date_found_lost' => 'nullable|date',
            'location_found_lost' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Create a new lost and found item
        $lostAndFoundItem = new LostItem();
        $lostAndFoundItem->item_name = $request->item_name;
        $lostAndFoundItem->description = $request->description;
        $lostAndFoundItem->type = $request->type;
        $lostAndFoundItem->status = 'reported';
        $lostAndFoundItem->reported_by = Auth::user()->id;  // Store the user who reported
        $lostAndFoundItem->date_found_lost = $request->date_found_lost;
        $lostAndFoundItem->location_found_lost = $request->location_found_lost;
        $lostAndFoundItem->remarks = $request->remarks;

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $lostAndFoundItem->image_path = $request->file('image')->store('lost_and_found_images', 'public');
        }

        // Save the item
        $lostAndFoundItem->save();

        return redirect()->route('lostAndFound')->with('success', 'Item reported successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Retrieve the lost and found item by ID along with the reporter details
        $item = LostItem::with('reporter')->findOrFail($id);

        // Return the view with the item details
        return view('lostFound.show_lost_and_found', compact('item'));
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


    public function updateStatus(Request $request, $id)
    {
        // 2. Validation
        $validated = $request->validate([
            'status'  => 'required|in:reported,claimed,returned,disposed',
            'remarks' => 'nullable|string|max:500',
        ]);

        // 3. Find Item
        $item = LostItem::findOrFail($id);

        // 4. Update the record
        // We also track WHO updated it using 'updated_by'
        $item->update([
            'status'     => $validated['status'],
            'remarks'    => $validated['remarks'],
            'updated_by' => Auth::id(),
        ]);

        // 5. Success Response
        return redirect()->route('showLostAndFound', $item->id)
            ->with('success', 'Item status has been updated to ' . ucfirst($validated['status']) . '.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
