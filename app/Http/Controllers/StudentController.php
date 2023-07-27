<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Profile;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchQuery = $request->input('search');

        $students = User::where('role_id', 2)
            ->when($searchQuery, function ($query, $searchQuery) {
                return $query->where('name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('email', 'like', '%' . $searchQuery . '%');
            })
            ->get();

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
        // Eager load the student profile along with the user
        $student = User::with('profileable')->findOrFail($id);
        return view('student.show', compact('student'));
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
        $user = User::findOrFail($id);
        $user->delete();

        // Redirect to the students list page with a success message
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
    public function toggleStatus(Request $request, $id)
    {
        $student = User::findOrFail($id);
        $newStatus = $student->status === 'active' ? 'passive' : 'active';
        $student->status = $newStatus;
        $student->save();

        return redirect()->route('students.index')->with('success', 'Student status changed successfully.');
    }

}
