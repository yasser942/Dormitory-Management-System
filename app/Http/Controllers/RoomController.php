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
    public function index()
    {
        $rooms = Room::all();
        return view('room.index',compact('rooms'));
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
        switch ($validatedData['type']) {
            case 'single':
                $capacity = 1;
                break;
            case 'double':
                $capacity = 2;
                break;
            case 'triple':
                $capacity = 3;
                break;
            case 'suit':
                $capacity = 2; // Capacity of 2 for a suit room
                break;
            case 'deluxe':
                $capacity = 2; // Capacity of 2 for a deluxe room
                break;
            case 'shared':
                $capacity = 4; // Capacity of 4 for a shared room
                break;
            default:
                $capacity = 1; // Default to 1 for unknown room types
        }

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
