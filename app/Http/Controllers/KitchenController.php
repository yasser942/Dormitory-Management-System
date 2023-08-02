<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchQuery = $request->input('search');

        $meals = Meal::when($searchQuery, function ($query, $searchQuery) {
            return $query->where('title', 'like', '%' . $searchQuery . '%')
                ->orWhere('status', 'like', '%' . $searchQuery . '%')
            ->orWhere('category', 'like', '%' . $searchQuery . '%');

        })->paginate(10);

        return view('meal.index', compact('meals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('meal.create');
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
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            //'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max file size if needed
            'status' => 'required|string|in:available,out_of_stock,special',
        ]);
/*
        // Handle the meal image upload, if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('meal_images', 'public');
            $validatedData['image'] = $imagePath;
        }
*/
        // Create a new meal with the validated data
        Meal::create($validatedData);

        // Redirect back to the kitchen facility page with a success message
        return redirect()->route('meals.index')->with('success', 'Meal created successfully!');
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
        $meal = Meal::findOrFail($id);
        return view('meal.edit',compact('meal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the meal by ID
        $meal = Meal::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            //'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max file size if needed
            'status' => 'required|string|in:available,out_of_stock,special',
        ]);
/*
        // Handle the meal image upload, if provided
        if ($request->hasFile('image')) {
            // Delete the old image file, if exists
            if ($meal->image) {
                Storage::disk('public')->delete($meal->image);
            }

            // Upload and store the new image
            $imagePath = $request->file('image')->store('meal_images', 'public');
            $validatedData['image'] = $imagePath;
        }
*/
        // Update the meal with the validated data
        $meal->update($validatedData);

        // Redirect back to the kitchen facility page with a success message
        return redirect()->route('meals.index')->with('success', 'Meal updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $meal = Meal::findOrFail($id);
        $meal->delete();
        return redirect()->route('meals.index')->with('success', 'Meal deleted successfully!');
    }
}
