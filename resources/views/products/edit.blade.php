
@include('products.form',[
    'title' => __('translation.Edit Product'),
    'route' => route('products.update',$product->id)
    ])
