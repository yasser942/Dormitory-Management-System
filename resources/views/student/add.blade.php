@extends('admin.admin_master')


@section('admin')
<div class="page-content">
    <div class="card border-top border-0 border-4 border-danger">
        <div class="card-body p-5">
            <div class="card-title d-flex align-items-center">
                <div><i class="bx bxs-user me-1 font-22 text-danger"></i>
                </div>
                <h5 class="mb-0 text-danger">Adding new student</h5>
            </div>
            <hr>
            <form class="row g-3" method="POST" action="{{route('students.store')}}">
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
                <!-- Hidden input for the role -->
                <input type="hidden" name="role_id" value="2">

                <div class="col-12">
                    <button type="submit" class="btn btn-danger px-5">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
