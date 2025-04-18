@include('meals.meal_categories_form',[
    'title' => 'تحديث تفاصيل الوجبة',
    'route' => route('meals.update_data',$category->id)
    ])
