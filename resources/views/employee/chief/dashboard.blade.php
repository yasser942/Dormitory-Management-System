@extends('admin.admin_master')


@section('admin')

    <div class="page-content">

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-2">
            <div class="col">
                <div class="card radius-10 bg-gradient-deepblue">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white">{{$totalMeals}}</h5>
                            <div class="ms-auto">
                                <i class='bx bxs-book-open fs-3 text-white'></i>
                            </div>
                        </div>
                        <div class="progress my-3 bg-light-transparent" style="height:3px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex align-items-center text-white">
                            <p class="mb-0">Total Meals</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10 bg-gradient-ohhappiness">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white">{{$distinctStudentCount}}</h5>
                            <div class="ms-auto">
                                <i class='bx bxs-graduation fs-3 text-white'></i>
                            </div>
                        </div>
                        <div class="progress my-3 bg-light-transparent" style="height:3px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex align-items-center text-white">
                            <p class="mb-0">Total Students</p>
                        </div>
                    </div>
                </div>
            </div>

        </div><!--end row-->

        <div class="row">
            <div class="col-12 col-lg-8 col-xl-8 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Library Traffic</h6>
                            </div>
                            <div class="font-22 ms-auto"><i class="bx bx-dots-horizontal-rounded"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center ms-auto font-13 gap-2 my-3">
                            <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #14abef"></i>Books Borrowed This Month</span>
                            <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #ade2f9"></i>Books Borrowed  Last Month</span>
                        </div>
                        <div class="chart-container-1">
                            <canvas id="chart1"></canvas>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-12 col-lg-4 col-xl-4 d-flex">
                <div class="card radius-10 overflow-hidden w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Books Info</h6>
                            </div>
                            <div class="font-22 ms-auto text-white"><i class="bx bx-dots-horizontal-rounded"></i>
                            </div>
                        </div>
                        <div class="chart-container-2 my-3">
                            <canvas id="chart2"></canvas>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <tbody>

                            <tr>
                                <td><i class="bx bxs-circle me-2" style="color: #02ba5a"></i>Not borrowed  Books</td>
                                <td id="data1"> {{$totalMeals-$boughtMealsCount}} </td>
                            </tr>
                            <tr>
                                <td><i class="bx bxs-circle me-2" style="color: #d31e1e"></i>Borrowed  Books</td>
                                <td id="data2"> {{$boughtMealsCount}} </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div><!--End Row-->





    </div>
    <script>
        var visitorData2 = @json($boughtMealsCountValuesPreviousMonth);

        var visitorData = @json($boughtMealsCountValuesCurrentMonth);

    </script>

@endsection



