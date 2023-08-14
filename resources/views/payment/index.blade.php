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
    @if(session('error'))


        <div class="alert border-0 border-start border-5 border-warning alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="font-35 text-warning"><i class='bx bxs-check-circle'></i>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-warning">Warning !</h6>
                    <div>{{ session('error') }}</div>
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
								<li class="breadcrumb-item active" aria-current="page">Students</li>
							</ol>
						</nav>
					</div>

				</div>
				<!--end breadcrumb-->

				<div class="card">
					<div class="card-body">
						<div class="d-lg-flex align-items-center mb-4 gap-3">
							<div class="position-relative">
                                <form action="{{ route('students.index') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search for student" name="search">
                                        <button class="btn btn-outline-primary" type="submit">Search</button>
                                    </div>
                                </form>
							</div>
						  <div class="ms-auto"><a href="{{route('students.create')}}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Student</a></div>
						</div>
						<div class="table-responsive">
							<table class="table mb-0">
								<thead class="table-light">
									<tr>
										<th>#</th>
										<th>Name</th>
                                        <th>Last Name</th>
                                        <th>Status</th>
                                        <th>Unpaid Fees</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($studentsWithUnpaidFees as  $student)
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
                                            <td>{{$student->name}}</td>
                                            <td>{{$student->last_name}}</td>
                                            <td>@if ( $student->fees->sum('amount')=== 0)
                                                    <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                                                        <i class='bx bxs-circle me-1'></i> Paid
                                                    </div>
                                                @else
                                                    <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
                                                        <i class='bx bxs-circle me-1'></i> Unpaid
                                                    </div>
                                                @endif</td>



                                            <td>$ {{ $student->fees->sum('amount') }}</td>

                                            <td>
                                                <div class="col">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle radius-30 px-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">Actions</button>
                                                        <ul class="dropdown-menu">

                                                            <form action="{{ route('markFeesAsPaid', ['userId' => $student->id]) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="lni lni-credit-cards"></i> Mark as Paid
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
                            <nav class="mt-4" aria-label="Page navigation example">
                                <ul class="pagination round-pagination">

                                    <!-- Previous Page Link -->
                                    @if ($studentsWithUnpaidFees->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $studentsWithUnpaidFees->previousPageUrl() }}">Previous</a></li>
                                    @endif

                                    <!-- Pagination Links -->
                                    @foreach ($studentsWithUnpaidFees->getUrlRange(1, $studentsWithUnpaidFees->lastPage()) as $page => $url)
                                        @if ($page == $studentsWithUnpaidFees->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach

                                    <!-- Next Page Link -->
                                    @if ($studentsWithUnpaidFees->hasMorePages())
                                        <li class="page-item"><a class="page-link" href="{{ $studentsWithUnpaidFees->nextPageUrl() }}">Next</a></li>
                                    @else
                                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                                    @endif

                                </ul>
                            </nav>
						</div>
					</div>
				</div>


			</div>

		<!--end page wrapper -->
@endsection
