<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchQuery = $request->input('search');

        $rooms = Room::when($searchQuery, function ($query, $searchQuery) {
            return $query->where('room_number', 'like', '%' . $searchQuery . '%')
                ->orWhere('type', 'like', '%' . $searchQuery . '%');
        })->paginate(10);


        return view('room.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('room.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'room_number' => 'required|string|unique:rooms',
            'type' => ['required', 'string', Rule::in(['single', 'double', 'triple', 'suit', 'deluxe', 'shared'])],
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);


        // Set the capacity based on the room type
        $capacity = match ($validatedData['type']) {
            'single' => 1,
            'double' => 2,
            'triple' => 3,
            'suit' => 2,
            'deluxe' => 2,
            'shared' => 4,
            default => 1,
        };


        // Add the capacity to the validated data
        $validatedData['capacity'] = $capacity;


        // Create a new room with the validated data
        Room::create($validatedData);

        // Redirect back to the rooms list with a success message
        return redirect()->route('rooms.index')->with('success', 'Room created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $room = Room::findOrFail($id);

        return view('room.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'room_number' => 'required|string|unique:rooms,room_number,' . $id,
            'type' => ['required', 'string', Rule::in(['single', 'double', 'triple', 'suit', 'deluxe', 'shared'])],
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);
        // Set the capacity based on the room type
        $capacity = match ($validatedData['type']) {
            'single' => 1,
            'double' => 2,
            'triple' => 3,
            'suit' => 2,
            'deluxe' => 2,
            'shared' => 4,
            default => 1,
        };

        // Add the capacity to the validated data
        $validatedData['capacity'] = $capacity;


        // Find the room by ID
        $room = Room::findOrFail($id);

        // Update the room with the validated data
        $room->update($validatedData);

        // Redirect back to the rooms list with a success message
        return redirect()->route('rooms.index')->with('success', 'Room updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        // Find the room by ID
        $room = Room::findOrFail($id);

        // Delete the room
        $room->delete();

        // Redirect back to the rooms list with a success message
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully!');
    }
}
