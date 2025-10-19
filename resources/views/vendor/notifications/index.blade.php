@extends('vendor.layouts.default')
@section('pageTitle', 'Notifications')
@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 text-gray-800">Notifications</h1>
    </div>


    <!-- Notifications List -->
        @forelse($notifications as $notification)
            <div class="alert 
                @if($notification->type == 'order') alert-primary
                @elseif($notification->type == 'payment') alert-success
                @elseif($notification->type == 'system') alert-dark
                @elseif($notification->type == 'account') alert-info
                @elseif($notification->type == 'feedback') alert-warning
                @elseif($notification->type == 'contact_us') alert-secondary
                @endif
                alert-dismissible fade show" role="alert">
                
                <strong>{{ ucfirst($notification->title) }}</strong> - {{ $notification->message }}

                @if($notification->url)
                    <a href="{{ $notification->url }}" class="btn btn-sm btn-light ml-2">View</a>
                @endif

            </div>
        @empty
            <div class="alert alert-light text-center" role="alert">
                No notifications available.
            </div>
        @endforelse


    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {!! $notifications->links('vendor.bootstrap-4') !!}
    </div>
</div>

<!-- JavaScript to Handle Notification Dismissal -->
<script>
    $(document).ready(function () {
        $(".alert .close").click(function () {
            let notificationId = $(this).data("id");
            $(this).parent().fadeOut();

            $.ajax({
                url: "{{ route('vendor.notifications.markAsRead') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    notification_id: notificationId
                },
                success: function (response) {
                    console.log(response.message);
                },
                error: function () {
                    console.log("Error marking notification as read!");
                }
            });
        });
    });
</script>

@endsection
