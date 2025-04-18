@include('splashes.form',[
    'title' => __('Edit splash'),
    'route' => route('splashes.update',$category->id)
    ])
