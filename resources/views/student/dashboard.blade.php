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

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-2">
            <div class="col">
                <div class="card radius-10 overflow-hidden w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Payments Info</h6>
                            </div>
                            <div class="font-22 ms-auto text-white"><i class="bx bx-dots-horizontal-rounded"></i>
                            </div>
                        </div>
                        <div class="chart-container-2 my-3">
                            <canvas id="chart20"></canvas>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <tbody>

                            <tr>
                                <td><i class="bx bxs-circle me-2" style="color: #02ba5a"></i>Library</td>
                                <td id="data1"> {{$libraryFees}} </td>
                            </tr>
                            <tr>
                                <td><i class="bx bxs-circle me-2" style="color: #d31e1e"></i>Room</td>
                                <td id="data2"> {{$roomFees}} </td>
                            </tr>
                            <tr>
                                <td><i class="bx bxs-circle me-2" style="color: #fba540"></i>Kitchen</td>
                                <td id="data3"> {{$kitchenFees}} </td>
                            </tr>
                            <tr>
                                <td><i class="bx bxs-circle me-2" style="color: #224272"></i>Gym</td>
                                <td id="data4"> {{$gymFees}} </td>
                            </tr>
                            <br>
                            <tr>
                                <td><i class="bx bxs-circle me-2" style="color: #7c18e7"></i>Total</td>
                                <td > {{$totalFees}} </td>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
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






    </div>
    <script>


    </script>

@endsection



