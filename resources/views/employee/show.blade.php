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
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">employee Profile</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('employees.index')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Employee Details</li>
                        </ol>
                    </nav>
                </div>

            </div>
            </div>
            <!--end breadcrumb-->
            <div class="container">
                <div class="main-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="{{asset('admin/assets/images/avatars/avatar-1.png')}}" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
                                        <div class="mt-3">
                                            <h4>{{$employee->name}} {{$employee->last_name}}</h4>
                                            <p class="text-secondary mb-1">{{$employee->profileable->job_title}}</p>
                                            <p class="text-muted font-size-sm">{{$employee->address}}</p>
                                            <button class="btn btn-primary">Follow</button>
                                            <button class="btn btn-outline-primary">Message</button>
                                        </div>
                                    </div>
                                    <hr class="my-4" />
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"> Employee Job</h6>
                                             <span class="text-secondary">{{$employee->profileable->job_title}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"> Employee Department</h6>
                                            <span class="text-secondary">{{$employee->profileable->department}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"> Employee Salary</h6>
                                            <span class="text-secondary">{{$employee->profileable->salary}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"> Employee Hire Date</h6>
                                            <span class="text-secondary">{{$employee->profileable->hire_date}}</span>
                                        </li>


                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <form class="row g-3" method="POST" action="{{route('employees.update',$employee->id)}}">

                                        @method('PUT')
                                        @csrf


                                        <div class="col-md-6">
                                            <label for="inputLastName1" class="form-label">First Name</label>
                                            <div class="input-group"> <span class="input-group-text bg-transparent"><i class='bx bxs-user'></i></span>
                                                <input type="text" class="form-control border-start-0" id="inputLastName1" placeholder="First Name" name="name" value="{{$employee->name}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputLastName2" class="form-label">Last Name</label>
                                            <div class="input-group"> <span class="input-group-text bg-transparent"><i class='bx bxs-user'></i></span>
                                                <input type="text" class="form-control border-start-0" id="inputLastName2" placeholder="Last Name" name="last_name" value="{{$employee->last_name}}"/>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="inputPhoneNo" class="form-label">Phone No</label>
                                            <div class="input-group"> <span class="input-group-text bg-transparent"><i class='bx bxs-microphone' ></i></span>
                                                <input type="text" class="form-control border-start-0" id="inputPhoneNo" placeholder="Phone No" name="phone"  value="{{$employee->phone}}"/>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="inputEmailAddress" class="form-label">Email Address</label>
                                            <div class="input-group"> <span class="input-group-text bg-transparent"><i class='bx bxs-message' ></i></span>
                                                <input type="text" class="form-control border-start-0" id="inputEmailAddress" placeholder="Email Address" name="email"  value="{{$employee->email}}"/>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="inputChoosePassword" class="form-label">Choose Password</label>
                                            <div class="input-group"> <span class="input-group-text bg-transparent"><i class='bx bxs-lock-open' ></i></span>
                                                <input type="password" class="form-control border-start-0" id="inputChoosePassword" placeholder="Choose Password" name="password" value="{{$employee->password}}" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="inputConfirmPassword" class="form-label">Confirm Password</label>
                                            <div class="input-group"> <span class="input-group-text bg-transparent"><i class='bx bxs-lock' ></i></span>
                                                <input type="password" class="form-control border-start-0" id="inputConfirmPassword" placeholder="Confirm Password"  name="password_confirmation" value="{{$employee->password}}"/>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="inputAddress3" class="form-label">Address</label>
                                            <textarea class="form-control" id="inputAddress3" placeholder="Enter Address" rows="3" name="address"  >{{$employee->address}}</textarea>
                                        </div>
                                        <!-- Hidden input for the role -->
                                        <input type="hidden" name="role_id" value="2">

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary px-5">Save Change</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
