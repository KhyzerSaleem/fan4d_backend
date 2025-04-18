@component('components.crud.list')
    @slot('title')
        @lang('translation.Orders')
    @endslot
    @slot('list')
        @lang('translation.Orders List')
    @endslot
    @slot('search_keys')
        @lang('translation.User Name')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('users.orders.data',$userId))
{{--    @slot('changeStatusRoute', route('orders.changeStatus'))--}}
@endcomponent
