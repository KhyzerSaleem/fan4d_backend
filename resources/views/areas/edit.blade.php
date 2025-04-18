@include('areas.form',[
    'title' => __('Edit areas'),
    'route' => route('areas.update',$category->id)
    ])
