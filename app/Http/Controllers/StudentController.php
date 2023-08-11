<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Profile;
use App\Models\Room;
use App\Models\StudentProfile;
use App\Models\User;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    use UploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchQuery = $request->input('search');

        $students = User::where('role_id', 2)
            ->when($searchQuery, function ($query, $searchQuery) {
                return $query->where(function ($subQuery) use ($searchQuery) {
                    $subQuery->where('name', 'like', '%' . $searchQuery . '%')
                        ->orWhere('email', 'like', '%' . $searchQuery . '%');
                });
            })->with('rooms') // Eager load the "room" relationship
            ->paginate(10);

        return view('student.index', compact('students', 'searchQuery'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('student.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create a new user with the validated data from the request
            $user = User::create($request->validated());


            // Create a student profile with constant values
            $studentProfileData = [
                'student_number' => '12345',
                'university' => 'Example University',
                'department' => 'Computer Science',
                'degree' => 'Bachelor',
                'enrollment_date' => now(),
                'graduation_date' => now()->addYears(4),
            ];

            // Associate the student profile with the user
            $studentProfile=StudentProfile::create($studentProfileData);
            $user['profileable_id'] = $studentProfile->id;
            $user['profileable_type'] = 'App\Models\StudentProfile';
            $user->save();

            $user->profileable()->save(new StudentProfile($studentProfileData));

            DB::commit();

            return redirect()->route('students.index')->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            DB::rollback();

            // Log the error for further investigation (you can use a logger here)

            return redirect()->back()->with('error', 'Failed to create user. Please try again later.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = User::findOrFail($id);
        $room = $student->rooms; // Accessing the room related to the student


        return view('student.show', compact('student', 'room'));
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
    public function update(Request $request, string $id): RedirectResponse
    {
        // Retrieve the existing student from the database
        $student = User::findOrFail($id);

        // Validate the request data manually, including uniqueness validation for email
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($student->id),
            ],
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'role_id' => 'required',
        ]);

        // Update the student with the validated data
        $student->update($request->all());

        // Redirect back to the student details page or any other appropriate page
        return redirect()->route('students.show', $student->id)->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $user->delete();

            // Check if the student has a profile before attempting to delete it
            if ($user->profileable_id) {
                $profile = StudentProfile::find($user->profileable_id);
                if ($profile) {
                    $profile->delete();
                }
            }

            // Commit the transaction as all operations have been successful
            DB::commit();

            // Redirect to the students list page with a success message
            return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
        } catch (\Exception $e) {
            // An error occurred, so rollback the transaction
            DB::rollback();

            // Redirect back to the previous page with an error message
            return redirect()->back()->with('error', 'An error occurred while deleting the student.');
        }
    }
    public function toggleStatus(Request $request, $id)
    {
        $student = User::findOrFail($id);
        $newStatus = $student->status === 'active' ? 'passive' : 'active';
        $student->status = $newStatus;
        $student->save();


        return redirect()->route('students.index')->with('success', 'Student status changed successfully.');
    }
     public function assignRoomForm($id){
        return view('student.assign-room',compact('id'));
     }
    public function assignStudentToRoom(Request $request)
    {

        $startDate = Carbon::parse($request->input('start_date'))->format('Y-m-d');
        $endDate = Carbon::parse($request->input('end_date'))->format('Y-m-d');
        $request['start_date'] = $startDate;
        $request['end_date'] = $endDate;
        // Validate the request data
        $request->validate([
            'type' => ['required', 'string', Rule::in(['single', 'double', 'triple', 'suit', 'deluxe', 'shared'])],
            'start_date' => ['required', 'date','after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);


        // Get the student ID from the request
        $studentId = $request->input('student_id');

        // Retrieve the student model
        $student = User::findOrFail($studentId);

        // Get the type from the request
        $type = $request->input('type');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Find the first available room of the specified type with enough capacity
        $room = Room::where('type', $type)
            ->where(function ($query) {
                $query->whereNull('capacity') // Rooms with unlimited capacity
                ->orWhereRaw('occupied < capacity'); // Rooms with enough capacity
            })
            ->first();

        if (!$room) {
            return redirect()->back()->with('error', 'No available rooms of the specified type with enough capacity.');
        }

        // Attach the student to the room with start date and end date
        $room->students()->attach($student, ['start_date' => $startDate, 'end_date' => $endDate]);

        // Increment the "occupied" column of the room
        $room->increment('occupied');

        // Check if the room is now fully occupied and update the status to "occupied"
        if ($room->occupied >= $room->capacity) {
            $room->status = 'occupied';
            $room->save();
        }

        // Redirect back with a success message
        return redirect()->route('students.index')->with('success', 'Student assigned to room successfully!');
    }

}
