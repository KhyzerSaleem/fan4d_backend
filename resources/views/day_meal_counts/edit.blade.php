@include('day_meal_counts.form',[
    'title' => __('Edit day_meal_count'),
    'route' => route('day_meal_counts.update',$category->id)
    ])
