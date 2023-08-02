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
            <div class="ms-auto"><a href="{{route('books.create')}}"
                                    class="btn btn-primary radius-30 mt-2 mt-lg-0"><i
                        class="bx bxs-plus-square"></i>Add New Book</a>
                <a href="{{route('books.index')}}"
                   class="btn btn-primary radius-30 mt-2 mt-lg-0"><i
                        class="bx bxs-book"></i>Book Gallery</a></div>
        </div>

				<hr/>

        <table class="table align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th><div>
                        <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                    </div></th>
                <th>Cover</th>
                <th>ISBN</th>
                <th>Title</th>
                <th>Author</th>
                <th>Publication Date</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
           @foreach($books as $book)
               <tr>
                   <td>
                       <div>
                           <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                       </div>
                   </td>
                   <td> <div class="recent-product-img">
                           <img src="{{asset('admin/assets/images/gallery/08.png')}}" alt="">
                       </div></td>
                   <td>
                       <div class="d-flex align-items-center">

                           <div class="ms-2">
                               <h6 class="mb-1 font-14">{{$book->isbn}}</h6>
                           </div>
                       </div>
                   </td>
                   <td>{{$book->title}}</td>
                   <td>{{$book->author}}</td>
                   <td>{{$book->publication_date}}</td>
                   <td>{{$book->category}}</td>

                   <td>
                       <div class="d-flex m-3">
                           <form action="{{ route('books.destroy', $book->id) }}" method="post">
                               @method('DELETE')
                               @csrf
                               <button type="submit" class="btn btn-outline-danger m-1"><i class='bx bx-trash mr-1'></i>Delete</button>
                           </form>
                           <a href="{{ route('books.edit', $book->id) }}" class="btn btn-outline-primary m-1"><i class="bx bx-edit mr-1"></i>Edit</a>
                       </div>
                   </td>
               </tr>
           @endforeach
        </table>
            </div>
    </div>

@endsection
