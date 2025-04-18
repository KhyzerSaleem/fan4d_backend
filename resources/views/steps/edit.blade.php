@include('steps.form',[
    'title' => __('Edit step'),
    'route' => route('steps.update',$slider->id)
    ])
