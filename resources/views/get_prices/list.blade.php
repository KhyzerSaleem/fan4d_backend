@component('components.crud.list')
    @slot('title')
        طلبات الحصول على تسعيرة
    @endslot
    @slot('list')
        قائمة طلبات الحصول على تسعيرة
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('get_prices.data'))
    @slot('deleteRoute', route('get_prices.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('get_prices.bulkDelete'))
@endcomponent
