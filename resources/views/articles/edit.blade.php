@include('articles.form',[
    'title' => __('Edit articles'),
    'route' => route('articles.update',$category->id)
    ])
