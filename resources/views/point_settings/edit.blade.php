@include('point_settings.points_form',[
    'title' => __('Edit point_settings'),
    'route' => route('point_settings.update',$category->id)
    ])
