<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use Illuminate\Http\Request;

class GymController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sport.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sport.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            //'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the image validation as needed
            'status' => 'required|in:open,closed,maintenance',
        ]);
/*
        // Upload and save the image (if provided)
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sports', 'public');
            $validatedData['image'] = $imagePath;
        }
*/

        // Create a new Sport instance with the validated data
        $sport = new Sport($validatedData);

        // Save the sport record in the database
        $sport->save();

        // Redirect back to the gym facilities list with a success message
        return redirect()->route('sports.index')->with('success', 'Sport added successfully!');
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
