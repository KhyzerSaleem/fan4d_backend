@component('components.crud.list')
    @slot('title')
        @lang('delivery_times')
    @endslot
    @slot('list')
        @lang('delivery_times List')
    @endslot
    @slot('add_new')
        @lang('Add food')
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('delivery_times.data'))
    @slot('createRoute', route('delivery_times.create'))
    @slot('deleteRoute', route('delivery_times.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('delivery_times.bulkDelete'))
    @slot('changeStatusMultiRoute', route('delivery_times.bulkChangeStatus'))
    @slot('changeStatusRoute', route('delivery_times.changeStatus'))
@endcomponent
