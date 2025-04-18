
@include('notifications.form',[
    'title' => __('translation.Send Notifications'),
    'route' => route('notifications.sendNotification')
    ])
