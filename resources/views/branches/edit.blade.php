@include('branches.form',[
    'title' => __('Edit branch'),
    'route' => route('branches.update',$category->id)
    ])
