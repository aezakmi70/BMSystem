<?php

namespace App\Http\Controllers;

use App\Models\Official;
use Illuminate\Http\Request;

class OfficialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all officials
        $officials = Official::with('resident')->latest()->paginate(10);
        
        // Return a view with the data
        return view('officials.index', compact('officials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return a view for creating a new official
        return view('officials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'position' => 'required|string',
            'complete_name' => 'required|string', // assuming the complete name comes as a string
            'email' => 'required|email',
            'official_contact_number' => 'required|string',
            'address' => 'required|string',
            'term_start' => 'required|date',
            'term_end' => 'required|date',
            'status' => 'required|string',
            'password' => 'required|string|min:8', // Make sure to hash the password
        ]);

        // Create a new official record
        Official::create([
            'position' => $validated['position'],
            'complete_name' => $validated['complete_name'],
            'email' => $validated['email'],
            'official_contact_number' => $validated['official_contact_number'],
            'address' => $validated['address'],
            'term_start' => $validated['term_start'],
            'term_end' => $validated['term_end'],
            'status' => $validated['status'],
            'password' => bcrypt($validated['password']), // Ensure password is hashed
        ]);

        // Redirect with a success message
        return redirect()->route('officials.index')->with('success', 'Official added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the official by ID and show details
        $official = Official::with('resident')->findOrFail($id);

        // Return a view to display the official details
        return view('officials.show', compact('official'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Find the official by ID
        $official = Official::findOrFail($id);

        // Return a view for editing the official
        return view('officials.edit', compact('official'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'position' => 'required|string',
            'complete_name' => 'required|string',
            'email' => 'required|email',
            'official_contact_number' => 'required|string',
            'address' => 'required|string',
            'term_start' => 'required|date',
            'term_end' => 'required|date',
            'status' => 'required|string',
            'password' => 'nullable|string|min:8', // Password is optional, but if provided, it should be hashed
        ]);

        // Find the official by ID
        $official = Official::findOrFail($id);

        // Update the official's data
        $official->update([
            'position' => $validated['position'],
            'complete_name' => $validated['complete_name'],
            'email' => $validated['email'],
            'official_contact_number' => $validated['official_contact_number'],
            'address' => $validated['address'],
            'term_start' => $validated['term_start'],
            'term_end' => $validated['term_end'],
            'status' => $validated['status'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $official->password,
        ]);

        // Redirect with a success message
        return redirect()->route('officials.index')->with('success', 'Official updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find and delete the official by ID
        $official = Official::findOrFail($id);
        $official->delete();

        // Redirect with a success message
        return redirect()->route('officials.index')->with('success', 'Official deleted successfully.');
    }
}
