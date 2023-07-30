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


    <div class="page-content">
				<div class="row">
					<div class="col-xl-9 mx-auto">
						<div class="card border-top border-0 border-4 border-primary">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="card-title d-flex align-items-center">
										<div><i class="bx bx-book me-1 font-22 text-primary"></i>
										</div>
										<h5 class="mb-0 text-primary">Create New Book</h5>
									</div>
									<hr/>
									<div class="row mb-3">
										<label for="title" class="col-sm-3 col-form-label">Title</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="title" placeholder="Title">
										</div>
									</div>
									<div class="row mb-3">
										<label for="ISBN" class="col-sm-3 col-form-label">ISBN</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="ISBN" placeholder="ISBN">
										</div>
									</div>
									<div class="row mb-3">
										<label for="Author" class="col-sm-3 col-form-label">Author</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="Author" placeholder="Author">
										</div>
									</div>
                                    <div class="row mb-3">
                                        <label for="Category" class="col-sm-3 col-form-label">Category</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="Category" placeholder="Category">
                                        </div>
                                    </div>

									<div class="row mb-3">
										<label for="date" class="col-sm-3 col-form-label">Publication Date</label>
										<div class="col-sm-9">
                                            <input type="text" class="form-control datepicker" placeholder="Publication Date" id="date"/>
										</div>
									</div>

									<div class="row mb-3">
										<label for="Description" class="col-sm-3 col-form-label">Description</label>
										<div class="col-sm-9">
											<textarea class="form-control" id="Description" rows="2" placeholder="Description"></textarea>
										</div>
									</div>

                                    <div class="row mb-3">
                                        <label for="Cover Image" class="col-sm-3 col-form-label">Cover Image</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="file" id="Cover Image">
                                        </div>
                                    </div>
									<div class="row">
										<label class="col-sm-3 col-form-label"></label>
										<div class="col-sm-9">
											<button type="submit" class="btn btn-primary px-5">Create</button>
										</div>
									</div>
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
