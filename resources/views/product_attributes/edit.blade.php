
@include('product_attributes.form',[
    'title' => __('translation.Edit Product'),
    'route' => route('product_attributes.update',$product->id)
    ])
