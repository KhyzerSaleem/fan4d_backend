@include('medical_instructions.form',[
    'title' => __('Edit medical_instructions'),
    'route' => route('medical_instructions.update',$category->id)
    ])
