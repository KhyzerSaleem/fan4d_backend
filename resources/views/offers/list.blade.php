@component('components.crud.list')
    @slot('title')
        @lang('offers')
    @endslot
    @slot('list')
        @lang('offers List')
    @endslot
    @slot('add_new')
        @lang('Add offers')
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('offers.data'))
    @slot('createRoute', route('offers.create'))
    @slot('deleteRoute', route('offers.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('offers.bulkDelete'))
    @slot('changeStatusMultiRoute', route('offers.bulkChangeStatus'))
    @slot('changeStatusRoute', route('offers.changeStatus'))
@endcomponent
