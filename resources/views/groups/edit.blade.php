@include('groups.form',[
    'title' => __('Edit Group'),
    'route' => route('groups.update',['product' => $product, 'group' => $group->id])
    ])
