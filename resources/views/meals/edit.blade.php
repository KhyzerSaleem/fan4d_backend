@include('meals.form',[
    'title' => __('Edit meal'),
    'route' => route('meals.update',$category->id)
    ])
