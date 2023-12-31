
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
				<div class="row">
					<div class="col-xl-9 mx-auto">
						<div class="card border-top border-0 border-4 border-primary">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="card-title d-flex align-items-center">
										<div><i class="bx bx-book me-1 font-22 text-primary"></i>
										</div>
										<h5 class="mb-0 text-primary">Create New Sport</h5>
									</div>
									<hr/>
                                    <form action="{{ route('sports.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
									<div class="row mb-3">
										<label for="title" class="col-sm-3 col-form-label">Title</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="title" placeholder="Title" name="title">
										</div>
									</div>
									<div class="row mb-3">
										<label for="Capacity" class="col-sm-3 col-form-label">Capacity</label>
										<div class="col-sm-9">
											<input type="number" class="form-control" id="Capacity" placeholder="Capacity"  name="capacity">
										</div>
									</div>
									<div class="row mb-3">
										<label for="price" class="col-sm-3 col-form-label">Price</label>
										<div class="col-sm-9">
											<input type="number" class="form-control" id="price" placeholder="Price" name="price" step="0.00">
										</div>
									</div>
                                    <div class="row mb-3">
                                        <label for="status" class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-9">

                                        <select name="status" class="form-select mb-3" aria-label="Default select example"  id="status">
                                            <option value="open">Open</option>
                                            <option value="closed">Closed</option>
                                            <option value="maintenance">Maintenance</option>

                                        </select>

                                    </div>
                                        </div>



									<div class="row mb-3">
										<label for="Description" class="col-sm-3 col-form-label">Description</label>
										<div class="col-sm-9">
											<textarea class="form-control" id="Description" rows="2" placeholder="Description" name="description"></textarea>
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
											<button type="submit" class="btn btn-primary px-5">Create</button>
										</div>
									</div>
								</div>
                                    </form>

							</div>
						</div>
					</div>
				</div>
				<!--end row-->

    </div>



@endsection
