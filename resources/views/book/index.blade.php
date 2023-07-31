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
        <div class="d-lg-flex align-items-center mb-4 gap-3">
            <div class="position-relative">
                <form action="{{ route('books.index') }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search for room" name="search">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>
            <div class="ms-auto"><a href="{{route('books.create')}}"
                                    class="btn btn-primary radius-30 mt-2 mt-lg-0"><i
                        class="bx bxs-plus-square"></i>Add New Book</a></div>
        </div>
				<hr/>
				<div class="row row-cols-1 row-cols-md-1 row-cols-lg-3 row-cols-xl-3">
					@foreach($books as $book )
                        <div class="col">
                            <div class="card">
                                <img src="{{asset('admin/assets/images/gallery/08.png')}}" class="card-img-top" alt="...">
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


                                </ul>
                                <div class="row-cols-3-cols-2 m-3">
                                    <form action="{{ route('books.destroy', $book->id) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger px-2"><i class='bx bx-trash mr-1'></i>Delete</button>

                                    </form>
                                    <button type="submit" class="btn btn-outline-primary px-2"><i class='bx bx-info-circle mr-1'></i>Info</button>

                                </div>

                            </div>
                        </div>
					@endforeach

				</div>
				<!--end row-->
    </div>
@endsection
