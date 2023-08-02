<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{asset('admin/assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">DSM</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="/dashboard" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">Home</div>
            </a>

        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-user"></i>
                </div>
                <div class="menu-title  ">Manage Users</div>
            </a>
            <ul>
                <li> <a href="{{route('students.index')}}"><i class="bx bx-right-arrow-alt"></i>Students</a>
                </li>
                <li> <a href="{{route('employees.index')}}"><i class="bx bx-right-arrow-alt"></i>Employees</a>
                   </li>
                <li> <a href="route ('all.products')"><i class="bx bx-right-arrow-alt"></i>Admins</a>
                </li>

            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-building'></i>
                </div>
                <div class="menu-title">Facilities </div>
            </a>
            <ul>
                <li> <a href="{{route('books.index')}}"><i class="bx bx-right-arrow-alt"></i>Library</a>
                </li>
                <li> <a href="{{route('sports.index')}}"><i class="bx bx-right-arrow-alt"></i>Gym</a>
                </li>
                <li> <a href="{{route('meals.index')}}"><i class="bx bx-right-arrow-alt"></i>Kitchen</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-door-open'></i>
                </div>
                <div class="menu-title">Manage Rooms</div>
            </a>
            <ul>
                <li> <a href="{{route('rooms.index')}}"><i class="bx bx-right-arrow-alt"></i>Rooms</a>
                </li>

            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx bx-repeat'></i>
                </div>
                <div class="menu-title">Notification</div>
            </a>
            <ul>
                <li> <a href="route('all.notification')"><i class="bx bx-right-arrow-alt"></i>All Notification</a>
                </li>

            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-lock'></i>
                </div>
                <div class="menu-title">Slider</div>
            </a>
            <ul>
                <li> <a href="route('all.sliders')"><i class="bx bx-right-arrow-alt"></i>View Sliders</a>
                </li>

            </ul>
        </li>

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-grid-alt'></i>
                </div>
                <div class="menu-title">Site Information</div>
            </a>
            <ul>
                <li> <a href="route('all.infos')"><i class="bx bx-right-arrow-alt"></i>View Site info</a>
                </li>

            </ul>
        </li>

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-donate-blood"></i>
                </div>
                <div class="menu-title">Reviews</div>
            </a>
            <ul>
                <li> <a href=" route('all.reviews') "><i class="bx bx-right-arrow-alt"></i>All reviews</a>
                </li>
            </ul>
        </li>
        <li>

    </ul>
    <!--end navigation-->
</div>
