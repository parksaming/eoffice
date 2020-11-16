@php
    $tyles = App\Models\Notification::$types
@endphp

@foreach ($notifications as $val)
    <li class="{{ $val->read_at? 'onview' : '' }}">
        <a href="{{ route('notification.view_notification', [$val->id]) }}">
            @if (in_array($val->type, [$tyles['nhanvanbanmoi'], $tyles['nhanvanbanchuyenxuly'], $tyles['capnhattrangthaivanban']]))
                <i class="fa fa-flag"></i>
            @elseif (in_array($val->type, [$tyles['nhancongviecmoi'], $tyles['nhanbaocaocongviec']]))
                <i class="fa fa-bar-chart"></i>
            @elseif (in_array($val->type, [$tyles['nhandangkylichtuan'], $tyles['dangkylichtuandaduocduyet'], $tyles['dangkylichtuandabituchoi']]))
                <i class="fa fa-calendar"></i>
            @endif
            <span>{{ $val->content }}</span><br>
            <em>{{ convertCarbonToVN($val->created_at) }}</em>
        </a>
    </li>
@endforeach

<script>
    let noUnReadNotification = parseInt(<?php echo $noUnReadNotification ?>);

    if (noUnReadNotification) {
        $('.notification-count').text(noUnReadNotification).removeClass('hidden');
    }
    else {
        $('.notification-count').text(noUnReadNotification).addClass('hidden');
    }
</script>