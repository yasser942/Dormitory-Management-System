<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\EmployeeProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchQuery = $request->input('search');

        $employees = User::where('role_id', 3)
            ->when($searchQuery, function ($query, $searchQuery) {
                return $query->where('name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('email', 'like', '%' . $searchQuery . '%');
            })
            ->get();

        return view('employee.index', compact('employees', 'searchQuery'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.add');
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


            // Create an employee profile with constant values

            $employeeProfileData = [
                'job_title' => 'Librarian',
                'department' => 'Example University',
                'salary' => 1000.00,
                'hire_date' => now(),

            ];

            // Associate the employee profile with the user
            $employeeProfile=EmployeeProfile::create($employeeProfileData);
            $user['profileable_id'] = $employeeProfile->id;
            $user['profileable_type'] = 'App\Models\EmployeeProfile';
            $user->save();

            $user->profileable()->save(new employeeProfile($employeeProfileData));


            DB::commit();

            return redirect()->route('employees.index')->with('success', 'User created successfully!');
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
        // Eager load the employee profile along with the user
        $employee = User::with('profileable')->findOrFail($id);
        return view('employee.show', compact('employee'));
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

        // Retrieve the existing employee from the database
        $employee = User::findOrFail($id);

        // Validate the request data manually, including uniqueness validation for email
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($employee->id),
            ],
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'role_id' => 'required',
        ]);

        // Update the employee with the validated data
        $employee->update($request->all());

        // Redirect back to the employee details page or any other appropriate page
        return redirect()->route('employees.show', $employee->id)->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user = User::findOrFail($id);
        $user->delete();

        // Redirect to the employees list page with a success message
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }
    public function toggleStatus(Request $request, $id)
    {
        $employee = User::findOrFail($id);
        $newStatus = $employee->status === 'active' ? 'passive' : 'active';
        $employee->status = $newStatus;
        $employee->save();

        return redirect()->route('employees.index')->with('success', 'Employee status changed successfully.');
    }
}
