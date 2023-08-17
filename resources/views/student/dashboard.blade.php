@extends('admin.admin_master')


@section('admin')

    <div class="page-content">

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-1">
            <div class="col">
                <div class="card radius-10 bg-gradient-deepblue">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white">{{$borrowedBooks}}</h5>
                            <div class="ms-auto">
                                <i class='bx bxs-book-open fs-3 text-white'></i>
                            </div>
                        </div>
                        <div class="progress my-3 bg-light-transparent" style="height:3px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex align-items-center text-white">
                            <p class="mb-0">Borrowed Books</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10 bg-gradient-ibiza">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white">{{$registeredSports}}</h5>
                            <div class="ms-auto">
                                <i class='bx bx-dumbbell fs-3 text-white'></i>
                            </div>
                        </div>
                        <div class="progress my-3 bg-light-transparent" style="height:3px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex align-items-center text-white">
                            <p class="mb-0">Registered Sports</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10 bg-gradient-ohhappiness">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white">{{$boughtMeals}}</h5>
                            <div class="ms-auto">
                                <i class='bx bxs-dish fs-3 text-white'></i>
                            </div>
                        </div>
                        <div class="progress my-3 bg-light-transparent" style="height:3px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex align-items-center text-white">
                            <p class="mb-0">Bought Meals</p>
                        </div>
                    </div>
                </div>
            </div>

        </div><!--end row-->

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-1">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="d-flex align-items-center mb-3">Room Info</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"> Room Number</h6>
                                <span class="text-secondary">{{count($student->rooms)>0?$student->rooms [0]->room_number:'Unassigned'}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"> Room Type</h6>
                                <span class="text-secondary">{{count($student->rooms)>0?$student->rooms [0]->type:'Unassigned'}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"> Start Date</h6>
                                <span class="text-secondary">{{ optional($student->rooms->first())->pivot->start_date ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"> End Date</h6>
                                <span class="text-secondary">{{ optional($student->rooms->first())->pivot->end_date ?? 'N/A' }}</span>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5">
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="widgets-icons rounded-circle mx-auto bg-light-primary text-primary mb-3"><i class='bx bx-book-open'></i>
                            </div>
                            <h4 class="my-1">${{$libraryFees}}</h4>
                            <p class="mb-0 text-secondary">Library</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="widgets-icons rounded-circle mx-auto bg-light-danger text-danger mb-3"><i class='bx bxs-home'></i>
                            </div>
                            <h4 class="my-1">${{$roomFees}}</h4>
                            <p class="mb-0 text-secondary">Room</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="widgets-icons rounded-circle mx-auto bg-light-info text-info mb-3"><i class='bx bx-dish'></i>
                            </div>
                            <h4 class="my-1">${{$kitchenFees}}</h4>
                            <p class="mb-0 text-secondary">Kitchen</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="widgets-icons rounded-circle mx-auto bg-light-success text-success mb-3"><i class='bx bx-dumbbell'></i>
                            </div>
                            <h4 class="my-1">${{$gymFees}}</h4>
                            <p class="mb-0 text-secondary">Gym</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="widgets-icons rounded-circle mx-auto bg-light-warning text-warning mb-3"><i class='bx bx-dollar'></i>
                            </div>
                            <h4 class="my-1">${{$totalFees}}</h4>
                            <p class="mb-0 text-secondary">Total</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->




    </div>
    <script>


    </script>

@endsection



