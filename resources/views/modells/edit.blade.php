@include('modells.form',[
    'title' => __('Edit Modell'),
    'route' => route('modells.update',$modell->id)
    ])
