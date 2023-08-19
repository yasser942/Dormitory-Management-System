

<header>

    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
            </div>

            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item mobile-search-icon">
                        <a class="nav-link" href="#">	<i class='bx bx-search'></i>
                        </a>
                    </li>

                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">{{count(auth()->user()->unreadNotifications)}}</span>
                            <i class='bx bx-bell'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="{{route('markAllAsRead')}}">
                                <div class="msg-header">
                                    <p class="msg-header-title">Notifications</p>
                                    <p class="msg-header-clear ms-auto">Marks all as read</p>
                                </div>
                            </a>
                            <div class="header-notifications-list">
                                @foreach(auth()->user()->unreadNotifications as $notification)
                                    <a class="dropdown-item" href="{{ route('markAsRead', ['notificationId' => $notification->id]) }}">
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-primary text-primary"><i class="bx bx-message-alt-detail"></i></div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">{{$notification->data['title']}}<span class="msg-time float-end">{{$notification->created_at->diffForHumans()}}
                    </span></h6>
                                                <p>{{\Str::limit($notification->data['message'],30)}}</p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach


                            </div>
                            <a href="{{route('notifications.index')}}">
                                <div class="text-center msg-footer">View All Notifications</div>
                            </a>
                        </div>
                    </li>




                    <li class="nav-item dropdown dropdown-large">

                        <div class="dropdown-menu dropdown-menu-end">




                            <div class="header-message-list">




                            </div>


                        </div>
                    </li>
                </ul>
            </div>

            <div class="user-box dropdown">
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                    @if(auth()->user()->image)
                        <img src="{{Storage::url('users/'.auth()->user()->image->filename)}}" alt="..." class="user-img" width="110">

                    @else
                        <img src="{{Storage::url('users/img.png')}}" alt="..." class="user-img" width="110">

                    @endif
                    <div class="user-info ps-3">
                        <p class="user-name mb-0">{{auth()->user()->name}}</p>
                        <p class="designattion mb-0">{{auth()->user()->email}}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    @if(auth()->user()->role_id==1)
                        <li><a class="dropdown-item" href=" {{route('profile.edit')}}"><i class="bx bx-key"></i><span>Edit Profile</span></a>
                        </li>
                    @else
                        @if(auth()->user()->role_id==3)
                        <li><a class="dropdown-item" href=" {{route('myProfile.update',auth()->user()->id)}}"><i class="bx bx-user"></i><span>Profile</span></a>
                        </li>
                        @else
                            <li><a class="dropdown-item" href=" {{route('student.profile',auth()->user()->id)}}"><i class="bx bx-user"></i><span>Profile</span></a>
                            </li>
                        @endif
                        <li><a class="dropdown-item" href=" {{route('profile.edit')}}"><i class="bx bx-key"></i><span>Change Password</span></a>
                        </li>

                    @endif



                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>


                       <li>
                           <form method="POST" action="{{ route('logout') }}">
                               @csrf

                               <button type="submit" class="dropdown-item" href="#"
                                  onclick="event.preventDefault();
                                        this.closest('form').submit();"><i class='bx bx-log-out-circle'></i><span>Logout</span></button>
                           </form>
                       </li>


                </ul>
            </div>
        </nav>
    </div>
</header>
