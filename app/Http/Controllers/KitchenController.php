<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Check if the meal has been bought by any user
        $isBought = $meal->users()->exists();

        if ($isBought) {
            return redirect()->route('meals.index')->with('error', 'Meal cannot be deleted as it has been bought by a user.');
        }

        // If the meal is not bought, proceed to delete it
        $meal->delete();

        return redirect()->route('meals.index')->with('success', 'Meal deleted successfully!');
    }


    public function buyMeal(Request $request, Meal $meal)
    {
        try {
            DB::beginTransaction();

            $user = auth()->user();

            // Check if the user is already registered for this meal
            if ($user->meals->contains($meal)) {
                throw new \Exception('You have already bought this meal.');
            }

            // Create a new fee record for the meal purchase
            $feeAmount = $meal->price;
            $feeDescription = 'Meal purchase - ' . $meal->name;
            $fee = Fee::create([
                'facility' => 'Kitchen',
                'amount' => $feeAmount,
                'description' => $feeDescription,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Attach the meal to the user with the purchase date
            $user->meals()->attach($meal->id, ['date' => now()]);

            // Attach the fee to the user
            $user->fees()->attach($fee->id);

            DB::commit();

            return redirect()->back()->with('success', 'Meal purchased successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to buy the meal: ' . $e->getMessage());
        }



    }

    public function membersList()
    {
        // Get the users with their related sports
        $users = User::has('meals')->with('meals')->paginate();
        return view('meal.members-list', compact('users'));
    }
    public function memberDetails($user)
    {
        // Find the user with the specified ID
        $user = User::findOrFail($user);

        // Get the sports related to the user with pagination
        $meals = $user->meals()->paginate();

        return view('meal.member-details', compact('user', 'meals'));
    }
}
