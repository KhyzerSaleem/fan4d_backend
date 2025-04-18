@component('components.crud.orders_list')
    @slot('title')
        الطلبات
    @endslot
    @slot('list')
        قائمة الطلبات
    @endslot
    @slot('search_keys')
         الطلب
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('orders.data'))
{{--    @slot('changeStatusRoute', route('orders.changeStatus'))--}}
@endcomponent
