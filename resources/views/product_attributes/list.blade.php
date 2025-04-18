@component('components.crud.list')
    @slot('title')
        @lang('product_attributes')
    @endslot
    @slot('list')
        @lang('product_attributes List')
    @endslot
    @slot('add_new')
        @lang('Add product_attributes')
    @endslot
    @slot('search_keys')
        @lang('Title'), @lang('Description')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('product_attributes.data',$id))
    @slot('createRoute', route('product_attributes.create',['id'=>$id]))
    @slot('deleteRoute', route('product_attributes.destroy', ':modelId'))
    @slot('changeTypeRoute', route('product_attributes.changeType'))

    @slot('parent_breadcrumb')
        <li class="breadcrumb-item"><a href="{{route('products.index')}}">@lang('Products')</a></li>
    @endslot
@endcomponent
