<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Sport;
use App\Models\User;
use App\Notifications\PushNotification;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class GymController extends Controller
{
    use UploadTrait;

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

    public function membersList()
    {
        // Get the users with their related sports
        $users = User::has('sports')->with('sports')->paginate();
        return view('sport.members-list', compact('users'));
    }
    public function memberDetails($user)
    {
        // Find the user with the specified ID
        $user = User::findOrFail($user);

        // Get the sports related to the user with pagination
        $sports = $user->sports()->paginate();

        return view('sport.member-details', compact('user', 'sports'));
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
        DB::beginTransaction();
        try {


        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => ['required', 'string', Rule::in(['open', 'closed', 'maintenance'])],
        ]);


        // Create a new Sport instance with the validated data
        $sport = Sport::create($validatedData);


            //Upload img
            $this->verifyAndStoreImage($request,'image','sports','public',$sport->id,'App\Models\Sport','title');
        DB::commit();


        // Redirect back to the gym facilities list with a success message
        return redirect()->route('sports.index')->with('success', 'Sport added successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to create the sport: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */

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

        DB::beginTransaction();
        try {
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
            if ($request->has('image')){

                // Delete old photo
                if ($sport->image){
                    $old_img = $sport->image->filename;
                    $this->Delete_attachment('public','sports/'.$old_img,$request->id);
                    $sport->image()->delete();
                }
                //Upload img
                $this->verifyAndStoreImage($request,'image','sports','public',$sport->id,'App\Models\Sport','title');
            }
        DB::commit();

        // Redirect back to the sports list with a success message
        return redirect()->route('sports.index')->with('success', 'Sport updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to update the sport: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
        $sport = Sport::findOrFail($id);

        // Check if there are no registered users for this sport
        if ($sport->users->isEmpty()) {
            if ($sport->image){
                $this->Delete_attachment('public','sports/'.$sport->image->filename,$sport->id);
                $sport->image()->delete();
            }

            $sport->delete();

            DB::commit();
            return redirect()->route('sports.index')->with('success', 'Sport deleted successfully!');
        } else {
            return redirect()->route('sports.index')->with('error', 'Cannot delete the sport. There are registered users for this sport.');
        }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete the sport: ' . $e->getMessage());
        }
    }

    public function registerForm (string $id)
    {
        $sport = Sport::findOrFail($id);
        return view('student.gym.register', compact('sport'));
    }



    public function register(Request $request, $sportId)
    {
        $startDate = Carbon::parse($request->input('start_date'))->format('Y-m-d');
        $endDate = Carbon::parse($request->input('end_date'))->format('Y-m-d');
        $request['start_date'] = $startDate;
        $request['end_date'] = $endDate;
        // Validate the request data
        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Check if the user is authenticated and is a student
        $user = auth()->user();
        if (!$user || $user->role_id !== 2) {
            return redirect()->back()->with('error', 'You must be a student to register for a sport.');
        }

        // Get the selected sport
        $sport = Sport::findOrFail($sportId);

        // Calculate the number of days between start_date and end_date
        $start = Carbon::parse($validatedData['start_date']);
        $end = Carbon::parse($validatedData['end_date']);
        $numberOfDays = $start->diffInDays($end);

        // Calculate the registration fee
        $feeAmount = $sport->price * $numberOfDays;

        // Create a new fee record in the fees table
        $fee = Fee::create([
            'facility' => 'Gym', // Assuming you want to specify that this fee is for a sport registration
            'amount' => $feeAmount,
            'description' => 'Sport registration fee for ' . $numberOfDays . ' days.',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        // Attach the sport to the user in the pivot table with the registration date
        $user->sports()->attach($sport, [
            'start_date' => $start,
            'end_date' => $end,
            'created_at' => now(),
        ]);
        $user->fees()->attach($fee->id);

        return redirect()->route('student.sports.index')->with('success', 'Successfully registered for the sport.');
    }

    public function unregisterUserFromSport($sportId, $userId)
    {
        try {
            DB::beginTransaction();

            // Step 1: Get the user and the sport
            $user = User::findOrFail($userId);
            $sport = Sport::findOrFail($sportId);

            // Step 2: Check if the user is registered for the sport
            if (!$user->sports->contains($sport)) {
                throw new \Exception('User is not registered for this sport.');
            }

            // Step 3: Calculate the fee
            $startDate = $user->sports->find($sport->id)->pivot->start_date;
            $endDate = now();

            // Calculate the number of days between start_date and end_date
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $numberOfDays = $start->diffInDays($end);

            // Calculate the fee amount
            $feeAmount = $sport->price * $numberOfDays;

            // Step 4: Update the existing fee record with the new fee amount and description
            $user->fees()->where('facility', 'Gym')->wherePivot('user_id', $user->id)->update([
                'amount' => $feeAmount,
                'description' => 'Sport fee for ' . $numberOfDays . ' days.',
                'updated_at' => now(),
            ]);

            // Step 5: Unregister the user from the sport by removing the sport from the pivot table
            $user->sports()->detach($sport->id);

            DB::commit();

            return redirect()->back()->with('success', 'User unregistered from the sport successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to unregister user from the sport: ' . $e->getMessage());
        }
    }





}
