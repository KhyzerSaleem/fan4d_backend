@include('attributes.form',[
    'title' => __('Edit attribute'),
    'route' => route('attributes.update',$category->id)
    ])
