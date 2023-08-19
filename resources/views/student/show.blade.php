@extends('admin.admin_master')
@section('admin')
    @if(session('success'))


        <div class="alert border-0 border-start border-5 border-success alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="font-35 text-success"><i class='bx bxs-check-circle'></i>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-success">Done !</h6>
                    <div>{{ session('success') }}</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
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
                <div class="breadcrumb-title pe-3">Student Profile</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('students.index')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Student Details</li>
                        </ol>
                    </nav>
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
                                        @if($student->image)
                                            <img src="{{Storage::url('users/'.$student->image->filename)}}" alt="..." class="rounded-circle p-1 bg-primary" width="110">

                                        @else
                                            <img src="{{asset('admin/assets/images/gallery/noimg.png')}}" alt="..." class="rounded-circle p-1 bg-primary" width="110">

                                        @endif<div class="mt-3">
                                            <h4>{{$student->name}} {{$student->last_name}}</h4>
                                            <p class="text-secondary mb-1">{{$student->profileable->department}}</p>
                                            <p class="text-muted font-size-sm">{{$student->address}}</p>

                                        </div>
                                    </div>
                                    <hr class="my-4" />
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"> Student Number</h6>
                                             <span class="text-secondary">{{$student->profileable->student_number}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"> Student University</h6>
                                            <span class="text-secondary">{{$student->profileable->university}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"> Student Department</h6>
                                            <span class="text-secondary">{{$student->profileable->department}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"> Student Degree</h6>
                                            <span class="text-secondary">{{$student->profileable->degree}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"> Start Date</h6>
                                            <span class="text-secondary">{{$student->profileable->enrollment_date}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"> Graduate Date</h6>
                                            <span class="text-secondary">{{$student->profileable->graduation_date}}</span>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <form class="row g-3" method="POST"
                                    @if(auth()->user()->role_id==1)
                                        action="{{route('students.update',$student->id)}} "  enctype="multipart/form-data">
                                    @else
                                        action="{{route('student.update-profile',$student->id)}} "  enctype="multipart/form-data">

                                    @endif
                                        @method('PUT')
                                        @csrf


                                        <div class="col-md-6">
                                            <label for="inputLastName1" class="form-label">First Name</label>
                                            <div class="input-group"> <span class="input-group-text bg-transparent"><i class='bx bxs-user'></i></span>
                                                <input type="text" class="form-control border-start-0" id="inputLastName1" placeholder="First Name" name="name" value="{{$student->name}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputLastName2" class="form-label">Last Name</label>
                                            <div class="input-group"> <span class="input-group-text bg-transparent"><i class='bx bxs-user'></i></span>
                                                <input type="text" class="form-control border-start-0" id="inputLastName2" placeholder="Last Name" name="last_name" value="{{$student->last_name}}"/>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="inputPhoneNo" class="form-label">Phone No</label>
                                            <div class="input-group"> <span class="input-group-text bg-transparent"><i class='bx bxs-microphone' ></i></span>
                                                <input type="text" class="form-control border-start-0" id="inputPhoneNo" placeholder="Phone No" name="phone"  value="{{$student->phone}}"/>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="inputEmailAddress" class="form-label">Email Address</label>
                                            <div class="input-group"> <span class="input-group-text bg-transparent"><i class='bx bxs-message' ></i></span>
                                                <input type="text" class="form-control border-start-0" id="inputEmailAddress" placeholder="Email Address" name="email"  value="{{$student->email}}"/>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="inputAddress3" class="form-label">Address</label>
                                            <textarea class="form-control" id="inputAddress3" placeholder="Enter Address" rows="3" name="address"  >{{$student->address}}</textarea>
                                        </div>
                                        <div class="col-12">
                                            <label for="Cover Image" class="col-sm-3 col-form-label">Image</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="file" id="Cover Image" name="image">
                                            </div>
                                        </div>
                                        <!-- Hidden input for the role -->
                                        <input type="hidden" name="role_id" value="2">

                                        <div class="col-12 mt-4">
                                            <button type="submit" class="btn btn-primary px-5">Save Change</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="d-flex align-items-center mb-3">Room Info</h5>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                    <h6 class="mb-0"> Room Number</h6>
                                                    <span class="text-secondary">{{count($student->rooms)>0?$student->rooms [0]->room_number:'Unassigned'}}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                    <h6 class="mb-0"> Room Type</h6>
                                                    <span class="text-secondary">{{count($student->rooms)>0?$student->rooms [0]->type:'Unassigned'}}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                    <h6 class="mb-0"> Start Date</h6>
                                                    <span class="text-secondary">{{ optional($student->rooms->first())->pivot->start_date ?? 'N/A' }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                    <h6 class="mb-0"> End Date</h6>
                                                    <span class="text-secondary">{{ optional($student->rooms->first())->pivot->end_date ?? 'N/A' }}</span>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
