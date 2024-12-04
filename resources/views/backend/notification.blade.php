@foreach($noti as $notifi)

<li class="notification-item today">
    <span class="notification-time"></span>
    <div class="notification-info">
        <div class="notification-details">
            <span class="notification-title">
                <a href="/admin/notification/{{$notifi->id}}">New Ride Request</a>
            </span>
            <span class="notification-text">
                <b>From</b>{{$notifi->data['rideData']['location_from']}} <b> To </b> {{$notifi->data['rideData']['location_to'] }}
            </span>
        </div>
    </div>
    <!-- <a href="#" class="remove-notification">&times;</a> -->
</li>
@endforeach