
@component('components.crud.list')
    @slot('title')
        @lang('product_attribute_options')
    @endslot
    @slot('list')
        @lang('product_attribute_options List')
    @endslot
    @slot('add_new')
        @lang('Add product_attribute_options')
    @endslot
    @slot('search_keys')
        @lang('Title'), @lang('Description')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('product_attribute_options.data',$id))
    @slot('createRoute', route('product_attribute_options.create',['id'=>$id])))
    @slot('deleteRoute', route('product_attribute_options.destroy', ':modelId'))
    @slot('parent_breadcrumb')
        <li class="breadcrumb-item"><a href="{{route('products.index')}}">@lang('Products')</a></li>
        <li class="breadcrumb-item"><a href="{{route('product_attributes.index',['id'=>$product_id])}}">@lang('product_attributes')</a></li>
    @endslot
@endcomponent
