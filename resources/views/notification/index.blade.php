@extends('admin.admin_master')
@section('admin')


    <div class="page-content">

        @foreach($notifications as $notification)
            <div class="card radius-10">
                <div class="card-body">
            <div class="d-flex align-items-center">
                <img src="{{asset('admin/assets/images/avatars/avatar-4.png')}}" class="align-self-start rounded-circle p-1 border" width="90" height="90" alt="...">
                <div class="flex-grow-1 ms-3">
                    <h5 class="mt-0">{{$notification->data['title']}}</h5>
                    <p>{{$notification->data['message']}}</p>
                    <p>{{$notification->created_at->diffForHumans()}}</p>

                </div>
                <a href="{{ route('markAsRead', ['notificationId' => $notification->id]) }}" class="btn-close"></a>
            </div>
                </div>
            </div>
        @endforeach
    </div>
    <nav class="mt-4" aria-label="Page navigation example">
        <ul class="pagination round-pagination">

            <!-- Previous Page Link -->
            @if ($notifications->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Previous</span></li>
            @else
                <li class="page-item"><a class="page-link"
                                         href="{{ $notifications->previousPageUrl() }}">Previous</a>
                </li>
            @endif

            <!-- Pagination Links -->
            @foreach ($notifications->getUrlRange(1, $notifications->lastPage()) as $page => $url)
                @if ($page == $notifications->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach

            <!-- Next Page Link -->
            @if ($notifications->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $notifications->nextPageUrl() }}">Next</a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif

        </ul>
    </nav>

@endsection
