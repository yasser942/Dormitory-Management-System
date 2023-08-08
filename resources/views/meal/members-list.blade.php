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

        <div class="alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="font-35 text-danger"><i class='bx bxs-check-circle'></i>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-danger">Error !</h6>
                    <div>{{ session('error') }}</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-body">

        <div class="d-lg-flex align-items-center mb-4 gap-3">
            <div class="position-relative">
                <form action="{{ route('books.index') }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search for book" name="search">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>

        </div>

				<hr/>

        <table class="table align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th><div>
                        <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                    </div></th>
                <th>Student Name</th>
                <th>Student Last Name</th>
                <th>Student Email</th>
                <th>Number Of Meals</th>
                <th>Actions</th>


            </tr>
            </thead>
            <tbody>
           @foreach($users as $user)
               <tr>
                   <td>
                       <div>
                           <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                       </div>
                   </td>
                   <td>{{ $user->name }}</td>
                   <td>{{ $user->last_name }}</td>
                   <td>{{ $user->email }}</td>
                   <td>{{ count($user->meals) }}</td>
                   <td> <a href="{{ route('meals.member-details', $user->id) }}" class="btn btn-outline-primary m-1"><i class="bx bx-edit mr-1"></i>Details</a></td>
               </tr>
           @endforeach
        </table>
            </div>
            <nav class="mt-4" aria-label="Page navigation example">
                <ul class="pagination round-pagination">

                    <!-- Previous Page Link -->
                    @if ($users->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $users->previousPageUrl() }}">Previous</a></li>
                    @endif

                    <!-- Pagination Links -->
                    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        @if ($page == $users->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    <!-- Next Page Link -->
                    @if ($users->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $users->nextPageUrl() }}">Next</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                    @endif

                </ul>
            </nav>

    </div>

@endsection
