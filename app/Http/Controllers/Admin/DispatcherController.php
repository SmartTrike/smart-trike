<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DispatcherDataTable;
use App\Http\Controllers\Controller;
use App\Models\DispatcherInformation;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DispatcherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DispatcherDataTable $dataTable)
    {
        return $dataTable->render('admin.dispatchers.index');
        // return view('admin.dispatchers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dispatchers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create the user (dispatcher) in the users table
        $user = User::create([
            'username' => $request->username,
            'role' => 'dispatcher',  // Set role as dispatcher
            'email' => $request->email,
            'password' => bcrypt($request->password), // Encrypt the password
        ]);

        // Create the dispatcher information
        DispatcherInformation::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'status' => 'active',
        ]);

        // Redirect back with a success message
        return redirect()->route('admin.dispatchers.index')->with('success', 'New dispatcher created successfully.');
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


    // public function getDispatchers(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $dispatchers = DispatcherInformation::select('id', 'first_name', 'last_name', 'contact_number', 'status');
    //         dd($dispatchers->get()); // Debugging to check the data

    //         return DataTables::of($dispatchers)
    //             ->addColumn('action', function ($dispatcher) {
    //                 return '<a href="' .'" class="btn btn-primary btn-sm">Edit</a>';
    //             })
    //             ->make(true);
    //     }
    // }
}
