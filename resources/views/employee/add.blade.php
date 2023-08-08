@extends('admin.admin_master')


@section('admin')
    @if($errors->any())
        <div class="alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="font-35 text-danger"><i class='bx bxs-x-circle'></i></div>
                <div class="ms-3">
                    <h6 class="mb-0 text-danger">Validation Error</h6>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
<div class="page-content">
    <div class="card border-top border-0 border-4 border-danger">
        <div class="card-body p-5">
            <div class="card-title d-flex align-items-center">
                <div><i class="bx bxs-user me-1 font-22 text-danger"></i>
                </div>
                <h5 class="mb-0 text-danger">Adding new employee</h5>
            </div>
            <hr>
            <form class="row g-3" method="POST" action="{{route('employees.store')}}">
                @csrf
                <div class="col-md-6">
                    <label for="inputLastName1" class="form-label">First Name</label>
                    <div class="input-group"> <span class="input-group-text bg-transparent"><i class='bx bxs-user'></i></span>
                        <input type="text" class="form-control border-start-0" id="inputLastName1" placeholder="First Name" name="name" />
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="inputLastName2" class="form-label">Last Name</label>
                    <div class="input-group"> <span class="input-group-text bg-transparent"><i class='bx bxs-user'></i></span>
                        <input type="text" class="form-control border-start-0" id="inputLastName2" placeholder="Last Name" name="last_name"/>
                    </div>
                </div>
                <div class="col-12">
                    <label for="inputPhoneNo" class="form-label">Phone No</label>
                    <div class="input-group"> <span class="input-group-text bg-transparent"><i class='bx bxs-microphone' ></i></span>
                        <input type="text" class="form-control border-start-0" id="inputPhoneNo" placeholder="Phone No" name="phone" />
                    </div>
                </div>
                <div class="col-12">
                    <label for="inputEmailAddress" class="form-label">Email Address</label>
                    <div class="input-group"> <span class="input-group-text bg-transparent"><i class='bx bxs-message' ></i></span>
                        <input type="text" class="form-control border-start-0" id="inputEmailAddress" placeholder="Email Address" name="email" />
                    </div>
                </div>
                <div class="col-12">
                    <label for="inputChoosePassword" class="form-label">Choose Password</label>
                    <div class="input-group"> <span class="input-group-text bg-transparent"><i class='bx bxs-lock-open' ></i></span>
                        <input type="text" class="form-control border-start-0" id="inputChoosePassword" placeholder="Choose Password" name="password" />
                    </div>
                </div>
                <div class="col-12">
                    <label for="inputConfirmPassword" class="form-label">Confirm Password</label>
                    <div class="input-group"> <span class="input-group-text bg-transparent"><i class='bx bxs-lock' ></i></span>
                        <input type="text" class="form-control border-start-0" id="inputConfirmPassword" placeholder="Confirm Password"  name="password_confirmation"/>
                    </div>
                </div>
                <div class="col-12">
                    <label for="inputAddress3" class="form-label">Address</label>
                    <textarea class="form-control" id="inputAddress3" placeholder="Enter Address" rows="3" name="address"></textarea>
                </div>
                <div class="col-12">
                    <div class="row mb-3">
                        <label for="salary" class="form-label">Salary</label>
                        <div class="input-group"> <span class="input-group-text bg-transparent"><i class='bx bxs-dollar-circle'></i></span>
                            <input type="number" class="form-control" id="salary" placeholder="Salary" name="salary" step="0.00">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <label for="Department" class="form-label">Department</label>
                    <div class="input-group"> <span class="input-group-text bg-transparent"><i class='bx bxs-building'></i></span>
                        <input type="text" class="form-control border-start-0" id="Department" placeholder="Department" name="department"/>
                    </div>
                </div>
                <div class="col-12">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-select mb-3" aria-label="role"  id="role">
                        <option value="librarian">librarian</option>
                        <option value="chief">chief</option>
                        <option value="trainer">trainer</option>

                    </select>
                </div>
                <!-- Hidden input for the role -->
                <input type="hidden" name="role_id" value="3">

                <div class="col-12">
                    <button type="submit" class="btn btn-danger px-5">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
