
@include('pages.form',[
    'title' => __('translation.'.$page->type),
    'route' => route('pages.update',$page->type)
    ])
