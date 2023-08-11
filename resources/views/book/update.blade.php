<!--plugins-->
<link href="{{ asset('admin/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/plugins/datetimepicker/css/classic.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/plugins/datetimepicker/css/classic.time.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/plugins/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('admin/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link href="{{ asset('admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
@extends('admin.admin_master')
@section('admin')
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
				<div class="row">
					<div class="col-xl-9 mx-auto">
						<div class="card border-top border-0 border-4 border-primary">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="card-title d-flex align-items-center">
										<div><i class="bx bx-book me-1 font-22 text-primary"></i>
										</div>
										<h5 class="mb-0 text-primary">Update Book</h5>
									</div>
									<hr/>
                                    <form action="{{ route('books.update',$book->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
									<div class="row mb-3">
										<label for="title" class="col-sm-3 col-form-label">Title</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="title" placeholder="Title" name="title" value="{{$book->title}}">
										</div>
									</div>
									<div class="row mb-3">
										<label for="ISBN" class="col-sm-3 col-form-label">ISBN</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="ISBN" placeholder="ISBN"  name="isbn" value="{{$book->isbn}}">
										</div>
									</div>
									<div class="row mb-3">
										<label for="Author" class="col-sm-3 col-form-label">Author</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="Author" placeholder="Author" name="author" value="{{$book->author}}">
										</div>
									</div>
                                    <div class="row mb-3">
                                        <label for="Category" class="col-sm-3 col-form-label">Category</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="Category" placeholder="Category" name="category" value="{{$book->category}}">
                                        </div>
                                    </div>

									<div class="row mb-3">
										<label for="date" class="col-sm-3 col-form-label">Publication Date</label>
										<div class="col-sm-9">
                                            <input type="text" class="form-control datepicker" placeholder="Publication Date" id="date" name="publication_date" value="{{$book->publication_date}}"/>
										</div>
									</div>

									<div class="row mb-3">
										<label for="Description" class="col-sm-3 col-form-label">Description</label>
										<div class="col-sm-9">
											<textarea class="form-control" id="Description" rows="2" placeholder="Description" name="description">{{$book->description}}</textarea>
										</div>
									</div>

                                    <div class="row mb-3">
                                        <label for="Cover Image" class="col-sm-3 col-form-label">Cover Image</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="file" id="Cover Image" name="image">
                                        </div>
                                    </div>
									<div class="row">
										<label class="col-sm-3 col-form-label"></label>
										<div class="col-sm-9">
											<button type="submit" class="btn btn-primary px-5">Update</button>
										</div>
									</div>
                                    </form>
								</div>

							</div>
						</div>
					</div>
				</div>
				<!--end row-->

    </div>

    <script src="{{asset('admin/assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/datetimepicker/js/legacy.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/datetimepicker/js/picker.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/datetimepicker/js/picker.time.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/datetimepicker/js/picker.date.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js')}}"></script>
    <script>
        $('.datepicker').pickadate({
            selectMonths: true,
            selectYears: true
        }),
            $('.timepicker').pickatime()
    </script>
    <script>
        $(function () {
            $('#date-time').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD HH:mm'
            });
            $('#date').bootstrapMaterialDatePicker({
                time: false
            });
            $('#time').bootstrapMaterialDatePicker({
                date: false,
                format: 'HH:mm'
            });
        });
    </script>

@endsection
