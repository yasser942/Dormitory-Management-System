<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeController extends Controller
{
    public function calculateAndAssignRoomFee($id)
    {
        try {
            DB::beginTransaction();

            // Step 1: Get the start_date and end_date of the room for the specified user
            $user = User::findOrFail($id);


            $room = $user->rooms()->first();

           // Assuming the relationship between User and Room is defined as "rooms" in User model
            if (!$room) {
                throw new \Exception('User does not have a room assigned.');
            }

            $startDate = $room->pivot->start_date;
            $endDate = $room->pivot->end_date;


            // Step 2: Calculate the number of days between start_date and end_date
            $start = \Carbon\Carbon::parse($startDate);
            $end = \Carbon\Carbon::parse($endDate);
            $numberOfDays = $start->diffInDays($end);


            // Step 3: Calculate the fee amount
            $feeAmount = $numberOfDays * 10;

            // Step 4: Create a new fee record
            $fee = Fee::create([
                'facility' => 'Room',
                'amount' => $feeAmount,
                'description' => 'Room fee for ' . $numberOfDays . ' days.',
                'updated_at=' =>now(),
                'created_at=' =>now(),

            ]);


            // Step 5: Assign the fee to the user in the pivot table fee_user
            $user->fees()->attach($fee->id);

            // Step 6: Unassign the room from the user
            $user->rooms()->detach($room->id);

            // Step 7: Decrement the occupied column of the room and update the status if needed
            $room->decrement('occupied');

            if ($room->occupied < $room->capacity) {
                $room->status = 'vacant';
            }

            $room->save();

            DB::commit();

            return redirect()->route('students.index')->with('success', 'Room fee calculated and assigned successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('students.index')->with('error', 'Failed to calculate and assign room fee: ' . $e->getMessage());
        }
    }
}
