@component('components.crud.list')
    @slot('title')
        @lang('cities')
    @endslot
    @slot('list')
        @lang('cities List')
    @endslot
    @slot('add_new')
        @lang('Add cities')
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('cities.data'))
    @slot('createRoute', route('cities.create'))
    @slot('deleteRoute', route('cities.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('cities.bulkDelete'))
    @slot('changeStatusMultiRoute', route('cities.bulkChangeStatus'))
    @slot('changeStatusRoute', route('cities.changeStatus'))
@endcomponent
