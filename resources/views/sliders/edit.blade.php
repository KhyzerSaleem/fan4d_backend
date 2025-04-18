@include('sliders.form',[
    'title' => __('Edit Slider'),
    'route' => route('sliders.update',$slider->id)
    ])
