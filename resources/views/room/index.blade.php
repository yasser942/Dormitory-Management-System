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
					<div class="breadcrumb-title pe-3">Dormitory</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i  class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Rooms</li>
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

				<div class="card">
					<div class="card-body">
						<div class="d-lg-flex align-items-center mb-4 gap-3">
							<div class="position-relative">
                                <form action="{{ route('rooms.index') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search for room" name="search">
                                        <button class="btn btn-outline-primary" type="submit">Search</button>
                                    </div>
                                </form>
							</div>
						  <div class="ms-auto"><a href="{{route('rooms.create')}}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Room</a></div>
						</div>
						<div class="table-responsive">
							<table class="table mb-0">
								<thead class="table-light">
									<tr>
										<th>#</th>
										<th>Room Number</th>
                                        <th>Room Type</th>
                                        <th>Room Status</th>
										<th>Created At</th>
                                        <th>Updated At</th>
                                        <th>View Details</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($rooms as  $room)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                                    </div>
                                                    <div class="ms-2">
                                                        <h6 class="mb-0 font-14">#{{$loop->iteration}}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{$room->room_number}}</td>
                                            <td>{{$room->type}}</td>
                                            <td>@if ($room->status === 'vacant')
                                                    <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                                                        <i class='bx bxs-circle me-1'></i> Vacant
                                                    </div>
                                                @else
                                                    <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
                                                        <i class='bx bxs-circle me-1'></i> Occupied
                                                    </div>
                                                @endif</td>

                                            <td>{{ $room->created_at->diffForHumans() }}</td>
                                            <td>{{ $room->updated_at->diffForHumans() }}</td>

                                            <td><a type="button" href="{{route('rooms.show',$room->id)}}" class="btn btn-primary btn-sm radius-30 px-4">View Details</a></td>
                                            <td>
                                                <div class="col">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle radius-30 px-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">Actions</button>
                                                        <ul class="dropdown-menu">
                                                            <!-- Delete Link -->
                                                            <form action="{{ route('rooms.destroy', $room->id) }}" method="post">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="lni lni-trash"></i> Delete
                                                                </button>
                                                            </form>
                                                            <!-- Form to Change room Status -->
                                                            <form action="{{ route('rooms.toggle-status', $room->id) }}" method="post">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="lni lni-power-switch"></i>
                                                                    @if ($room->status === 'active')
                                                                        Deactivate
                                                                    @else
                                                                        Activate
                                                                    @endif
                                                                </button>
                                                            </form>



                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
									@endforeach

								</tbody>
							</table>
						</div>
					</div>
				</div>


			</div>

		<!--end page wrapper -->
@endsection
