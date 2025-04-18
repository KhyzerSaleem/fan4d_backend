@include('cities.form',[
    'title' => __('Edit cities'),
    'route' => route('cities.update',$category->id)
    ])
