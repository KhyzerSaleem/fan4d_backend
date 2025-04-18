@component('components.crud.list')
    @slot('title')
        @lang('Products')
    @endslot
    @slot('list')
        @lang('Products List')
    @endslot
    @slot('add_new')
        @lang('Add Product')
    @endslot
    @slot('search_keys')
        @lang('Title'), @lang('Description')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('products.data'))
    @slot('createRoute', route('products.create'))
    @slot('deleteRoute', route('products.destroy', ':modelId'))
{{--    @slot('generateGroupsRoute', route('products.generateOptionsGroups', ':modelId'))--}}
    @slot('deleteMultiRoute', route('products.bulkDelete'))
    @slot('changeStatusRoute', route('products.changeStatus'))
{{--    @slot('changeShowOnAppRoute', route('products.changeShowOnApp'))--}}
@endcomponent

