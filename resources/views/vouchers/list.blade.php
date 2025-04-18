@component('components.crud.list')
    @slot('title')
        @lang('Vouchers')
    @endslot
    @slot('list')
        @lang('Vouchers List')
    @endslot
    @slot('add_new')
        @lang('Add Voucher')
    @endslot
    @slot('search_keys')
        @lang('Voucher Code')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('vouchers.data'))
    @slot('createRoute', route('vouchers.create'))
    @slot('deleteRoute', route('vouchers.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('vouchers.bulkDelete'))
    @slot('changeStatusRoute', route('vouchers.changeStatus'))
    @slot('changeFirstOrderRoute', route('vouchers.changeFirstOrder'))
@endcomponent
