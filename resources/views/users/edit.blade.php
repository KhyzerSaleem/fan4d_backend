@include('users.form',[
    'title' => __('Edit user'),
    'route' => route('users.update',$data->id)
    ])
