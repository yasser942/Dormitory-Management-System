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
					<div class="breadcrumb-title pe-3">Rooms</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="{{route('rooms.index')}}"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Create Room</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							<button type="button" class="btn btn-primary">Settings</button>
							<button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
								<a class="dropdown-item" href="javascript:;">Another action</a>
								<a class="dropdown-item" href="javascript:;">Something else here</a>
								<div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
							</div>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
				<div class="row">
					<div class="col-xl-9 mx-auto">

						<div class="card">
							<div class="card-body">
                                <form action="{{route('rooms.store')}}" method="POST">
                                    @csrf
                                    <label for="roomNumber" class="form-label">Room Number</label>
                                    <input  name="room_number" class="form-control mb-3" type="text" placeholder="Ex. Room-1" aria-label="default input example" id="roomNumber">
                                    <label for="roomType" class="form-label">Room Type</label>
                                    <select name="type" class="form-select mb-3" aria-label="Default select example"  id="roomType">
                                        <option selected>--select-- </option>
                                        <option value="single">Single Room</option>
                                        <option value="double">Double Room</option>
                                        <option value="triple">Triple Room</option>
                                        <option value="suite">Suite</option>
                                        <option value="deluxe">Deluxe Room</option>
                                        <option value="shared">Shared Room</option>
                                    </select>
                                    <label for="price" class="form-label">Room Price</label>
                                    <input name="price" class="form-control mb-3" type="number" placeholder="100.00" aria-label="default input example" id="price" min="0">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea  class="form-control" id="description" placeholder="Enter Description" rows="3" name="description"></textarea>
                                    <div class="col-12 mt-4" >
                                        <button type="submit" class="btn btn-primary px-5">Add</button>
                                    </div>
                                </form>



							</div>
						</div>





					</div>
				</div>
				<!--end row-->
			</div>
@endsection
