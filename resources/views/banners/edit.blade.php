@include('banners.form',[
    'title' => __('Edit banner'),
    'route' => route('banners.update',$slider->id)
    ])
