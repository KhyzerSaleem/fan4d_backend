@include('foods.form',[
    'title' => __('Edit food'),
    'route' => route('foods.update',$category->id)
    ])
