@include('categories.form',[
    'title' => __('Edit Category'),
    'route' => route('categories.update',$category->id)
    ])
