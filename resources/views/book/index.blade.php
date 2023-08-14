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
                    <h6 class="mb-0 text-danger">Error!</h6>
                    <div>{{ session('error') }}</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="page-content">
        <div class="d-lg-flex align-items-center mb-4 gap-3">
            <div class="position-relative">
                <form action="{{auth()->user()->role_id==1? route('books.index'):route('student.books.index') }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search for book" name="search">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>
            @if(auth()->user()->role_id==1||(auth()->user()->profileable->job_title=='librarian'))
                <div class="ms-auto"><a href="{{auth()->user()->role_id==1?route('books.create'):route('library.create')}}"
                                        class="btn btn-primary radius-30 mt-2 mt-lg-0"><i
                            class="bx bxs-plus-square"></i>Add New Book</a>


                    <a href="{{auth()->user()->role_id==1?route('books.members-list'):route('employee.members-list')}}"
                       class="btn btn-primary radius-30 mt-2 mt-lg-0"><i
                            class="bx bxs-user-detail"></i>Members List</a></div>
            @endif

        </div>

				<hr/>
				<div class="row row-cols-1 row-cols-md-1 row-cols-lg-3 row-cols-xl-3">
					@foreach($books as $book )
                        <div class="col">
                            <div class="card">
                                @if($book->image)
                                    <img src="{{Storage::url('books/'.$book->image->filename)}}" alt="..." class="card-img">

                                @else
                                    <img src="{{asset('admin/assets/images/gallery/noimg.png')}}" alt="..." class="card-img">

                                @endif
                                <div class="card-body">
                                    <h5 class="card-title text-primary">{{$book->title}}</h5>
                                    <p class="card-text">{{$book->description}}</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"> ISBN</h6>
                                        <span class="text-secondary">{{$book->isbn}}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"> Category</h6>
                                        <span class="text-secondary">{{$book->category}}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"> Publication Date</h6>
                                        <span class="text-secondary">{{$book->publication_date}}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"> Author</h6>
                                        <span class="text-secondary">{{$book->author}}</span>
                                    </li>
                                    @if($book->isBorrowedBy(auth()->user()))
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0 text-primary"> Borrowing Date</h6>
                                            <span class="text-secondary">{{auth()->user()->books->find($book->id)->pivot->start_date}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0 text-danger"> Due Date</h6>
                                            <span class="text-secondary">{{auth()->user()->books->find($book->id)->pivot->start_date}}</span>
                                        </li>
                                    @endif

                                </ul>
                                @if(auth()->user()->role_id==1||(auth()->user()->profileable->job_title=='librarian'))
                                    <div class="d-flex m-3">
                                        <form action="{{ auth()->user()->role_id==1?route('books.destroy', $book->id):route('library.destroy', $book->id) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger m-1"><i class='bx bx-trash mr-1'></i>Delete</button>
                                        </form>
                                        <a href="{{  auth()->user()->role_id==1?route('books.edit', $book->id): route('library.edit', $book->id)}}" class="btn btn-outline-primary m-1"><i class="bx bx-edit mr-1"></i>Edit</a>
                                    </div>
                                @endif
                                @if(auth()->user()->role_id==2)
                                    @if ($book->isBorrowedBy(auth()->user())) {{-- Check if the book is not borrowed by the current user --}}
                                    <form action="{{route('student.books.return',$book->id)}}" method="post">
                                        @csrf
                                        <!-- Your form fields here -->
                                        <div class="d-flex m-3">
                                        <button type="submit" class="btn btn-outline-warning m-1"><i class='bx bx-arrow-back mr-1'></i>Return</button>
                                        </div>

                                    </form>
                                    @else
                                    <div class="d-flex m-3">
                                        <a href="{{ route('student.books.borrow-form', $book->id) }}" class="btn btn-outline-primary m-1"><i class="bx bx-book-add mr-1"></i>Borrow</a>
                                    </div>
                                    @endif
                                @endif


                            </div>
                        </div>
					@endforeach

				</div>
				<!--end row-->
        <nav class="mt-4" aria-label="Page navigation example">
            <ul class="pagination round-pagination">

                <!-- Previous Page Link -->
                @if ($books->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $books->previousPageUrl() }}">Previous</a></li>
                @endif

                <!-- Pagination Links -->
                @foreach ($books->getUrlRange(1, $books->lastPage()) as $page => $url)
                    @if ($page == $books->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                <!-- Next Page Link -->
                @if ($books->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $books->nextPageUrl() }}">Next</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif

            </ul>
        </nav>
    </div>
@endsection
