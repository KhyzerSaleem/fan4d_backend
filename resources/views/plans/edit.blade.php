@include('plans.form',[
    'title' => __('Edit plan'),
    'route' => route('plans.update',$data->id)
    ])
