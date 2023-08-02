<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GymController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $searchQuery = $request->input('search');

        $sports = Sport::when($searchQuery, function ($query, $searchQuery) {
            return $query->where('title', 'like', '%' . $searchQuery . '%')
                ->orWhere('status', 'like', '%' . $searchQuery . '%');
        })->paginate(10);

        return view('sport.index', compact('sports'));
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            //'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => ['required', 'string', Rule::in(['open', 'closed', 'maintenance'])],
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
        $sport = Sport::findOrFail($id);
        return view('sport.edit',compact('sport'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $sport = Sport::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            //'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => ['required', 'string', Rule::in(['open', 'closed', 'maintenance'])],
        ]);

        // Update the sport record with the validated data
        $sport->update($validatedData);
   /*
        // Handle the image upload if provided in the request
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sport_images', 'public');
            $sport->image = $imagePath;
            $sport->save();
        }

*/
        // Redirect back to the sports list with a success message
        return redirect()->route('sports.index')->with('success', 'Sport updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sport = Sport::findOrFail($id);
        $sport->delete();
        return redirect()->route('sports.index')->with('success', 'Sport deleted successfully!');

    }
}
