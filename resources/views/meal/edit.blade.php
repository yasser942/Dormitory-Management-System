
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
				<div class="row">
					<div class="col-xl-9 mx-auto">
						<div class="card border-top border-0 border-4 border-primary">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="card-title d-flex align-items-center">
										<div><i class="bx bx-book me-1 font-22 text-primary"></i>
										</div>
										<h5 class="mb-0 text-primary">Create New Meal</h5>
									</div>
									<hr/>
                                    <form action="{{ route('meals.update',$meal->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
									<div class="row mb-3">
										<label for="title" class="col-sm-3 col-form-label">Title</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="title" placeholder="Title" name="title" value="{{$meal->title}}">
										</div>
									</div>
									<div class="row mb-3">
										<label for="category" class="col-sm-3 col-form-label">category</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="category" placeholder="Category"  name="category" value="{{$meal->category}}">
										</div>
									</div>
									<div class="row mb-3">
										<label for="price" class="col-sm-3 col-form-label">Price</label>
										<div class="col-sm-9">
											<input type="number" class="form-control" id="price" placeholder="Author" name="price" step="0.00" value="{{$meal->price}}">
										</div>
									</div>
                                    <div class="row mb-3">
                                        <label for="status" class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-9">

                                        <select name="status" class="form-select mb-3" aria-label="Default select example"  id="status" >
                                            <option selected>{{$meal->status}}</option>
                                            <option value="available">available</option>
                                            <option value="out_of_stock">out_of_stock</option>
                                            <option value="special">special</option>

                                        </select>

                                    </div>



									<div class="row mb-3">
										<label for="Description" class="col-sm-3 col-form-label">Description</label>
										<div class="col-sm-9">
											<textarea class="form-control" id="Description" rows="2" placeholder="Description" name="description">{{$meal->title}}</textarea>
										</div>
									</div>

                                    <div class="row mb-3">
                                        <label for="Cover Image" class="col-sm-3 col-form-label">Cover Image</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="file" id="Cover Image" name="cover_image">
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
