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
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Notifications</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('notifications.index')}}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Send Notification</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-xl-9 mx-auto">

                <div class="card">
                    <div class="card-body">
                        <form action="{{route('notify')}}" method="POST">
                            @csrf
                            <label for="title" class="form-label">Title</label>
                            <input  name="title" class="form-control mb-3" type="text" placeholder="Title" aria-label="default input example" id="title">
                            <label for="target" class="form-label">Target</label>
                            <select name="target" class="form-select mb-3" aria-label="Default select example"  id="target">
                                <option value="all">All</option>
                                <option value="students">Students</option>
                                <option value="employees">Employees</option>

                            </select>
                            <label for="message" class="form-label">Message</label>
                            <textarea  class="form-control" id="message" placeholder="Enter Message" rows="3" name="message"></textarea>
                            <div class="col-12 mt-4" >
                                <button type="submit" class="btn btn-primary px-5">Send</button>
                            </div>
                        </form>



                    </div>
                </div>





            </div>
        </div>
        <!--end row-->
    </div>

@endsection
