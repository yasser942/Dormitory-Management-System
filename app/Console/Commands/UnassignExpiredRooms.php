<?php

namespace App\Console\Commands;

use App\Http\Controllers\FeeController;
use App\Models\Fee;
use App\Models\Room;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UnassignExpiredRooms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rooms:unassign_expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unassign users from rooms when their end_date has expired.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired rooms...');

        try {
            DB::beginTransaction();

            $now = now();

            $expiredRoomUserEntries = DB::table('room_student')
                ->where('end_date', '<', $now)
                ->get();

            foreach ($expiredRoomUserEntries as $roomUserEntry) {
                // Unassign the user from the room
                $roomId = $roomUserEntry->room_id;
                $studentId = $roomUserEntry->student_id;
                $room = Room::find($roomId);
                $student = User::find($studentId);

                if ($room && $student) {
                    $this->calculateAndAssignRoomFee($student->id);


                    $student->rooms()->detach($room->id);

                    // Update the room's status and occupied column if necessary
                    if ($room->students->isEmpty()) {
                        $room->status = 'vacant';
                        $room->occupied = 0;
                    } else {
                        $room->occupied = $room->students->count();
                    }

                    $room->save();
                }
            }

            DB::commit();
            $this->info('Unassigning users from expired rooms completed.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to unassign users from expired rooms: ' . $e->getMessage());
            $this->error('An error occurred while unassigning users from expired rooms. Check the error logs for more details.');
        }
    }

    protected function calculateAndAssignRoomFee($id)
    {
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
    }
}
