@include('units.form',[
    'title' => __('Edit unit'),
    'route' => route('units.update',$category->id)
    ])
