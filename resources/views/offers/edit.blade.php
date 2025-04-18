@include('offers.form',[
    'title' => __('Edit offers'),
    'route' => route('offers.update',$data->id)
    ])
