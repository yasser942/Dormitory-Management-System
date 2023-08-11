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
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Dormitory</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Meals</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <form action="{{ route('meals.index') }}" method="GET">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Search for meal" name="search">
                                <button class="btn btn-outline-primary" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                    <div class="ms-auto"><a href="{{auth()->user()->role_id==1?route('meals.create'):route('kitchen.create')}}"
                                            class="btn btn-primary radius-30 mt-2 mt-lg-0"><i
                                class="bx bxs-plus-square"></i>Add New meal</a>
                        <a href="{{auth()->user()->role_id==1?route('meals.members-list'):route('employee.members-list')}}"
                           class="btn btn-primary radius-30 mt-2 mt-lg-0"><i
                                class="bx bx-list-ul"></i>Show Members</a></div>
                </div>
                <hr/>



                        <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2">
                            @foreach($meals as $meal)
                            <div class="col">
                                <div class="card">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            @if($meal->image)
                                                <img src="{{Storage::url('meals/'.$meal->image->filename)}}" alt="..." class="card-img">

                                            @else
                                                <img src="{{asset('admin/assets/images/gallery/09.png')}}" alt="..." class="card-img">

                                            @endif
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title">{{$meal->title}}</h5>
                                                <p class="card-text">{{$meal->description}}</p>
                                                @if (auth()->user()->role_id == 2 && auth()->user()->meals->where('id', $meal->id)->count()  > 0)

                                                        <p class="text-success"> You have registered for this meal</p>
                                                @endif



                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                       @if(auth()->user()->role_id==1||(auth()->user()->profileable->job_title=='chief'))
                                                            <div class="d-flex">
                                                                <a href="{{ auth()->user()->role_id==1?route('meals.edit', $meal->id):route('kitchen.edit', $meal->id) }}" class="btn btn-outline-primary btn-sm me-2"><i class='bx bx-edit mr-1'></i>Edit</a>
                                                                <form action="{{ auth()->user()->role_id==1? route('meals.destroy',$meal->id): route('kitchen.destroy',$meal->id)}}" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class='bx bx-trash mr-1'></i>Delete</button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                        @if(auth()->user()->role_id==2)
                                                            @if($meal->status=='available')
                                                                <form action="{{route('meals.buy', $meal->id)}}" method="post">
                                                                    @csrf
                                                                    <div class="d-flex">
                                                                        <button type="submit" class="btn btn-outline-warning m-1"><i class='bx bx-arrow-back mr-1'></i>Buy</button>
                                                                    </div>

                                                                </form>
                                                            @endif
                                                       @endif
                                                        <div class="mt-2">
                                                            @if ($meal->status =='special')
                                                                <span class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase"><i class='bx bxs-circle align-middle me-1'></i>{{ $meal->status }}</span>
                                                            @elseif ($meal->status =='out_of_stock')
                                                                <span class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase"><i class='bx bxs-circle align-middle me-1'></i>{{ $meal->status }}</span>
                                                            @else
                                                                <span class="badge rounded-pill text-success bg-light-success p-2 text-uppercase"><i class='bx bxs-circle align-middle me-1'></i>{{ $meal->status }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="d-none d-md-block">
                                                        <!-- Put additional content here if needed, visible only on medium and larger screens -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>




			</div>

		<!--end page wrapper -->
@endsection
