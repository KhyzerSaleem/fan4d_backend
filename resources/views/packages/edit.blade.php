@include('packages.form',[
    'title' => __('Edit package'),
    'route' => route('packages.update',$category->id)
    ])
