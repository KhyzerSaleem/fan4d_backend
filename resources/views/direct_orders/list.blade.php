@component('components.crud.list')
    @slot('title')
        الطلبات المباشرة
    @endslot
    @slot('list')
        قائمة الطلبات المباشرة
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('direct_orders.data'))
    @slot('deleteRoute', route('direct_orders.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('direct_orders.bulkDelete'))
@endcomponent
