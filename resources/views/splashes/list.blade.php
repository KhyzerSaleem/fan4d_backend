@component('components.crud.list')
    @slot('title')
        @lang('splashes')
    @endslot
    @slot('list')
        @lang('splashes List')
    @endslot
    @slot('add_new')
        @lang('Add splash')
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('splashes.data'))
    @slot('createRoute', route('splashes.create'))
    @slot('deleteRoute', route('splashes.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('splashes.bulkDelete'))
    @slot('changeStatusMultiRoute', route('splashes.bulkChangeStatus'))
    @slot('changeStatusRoute', route('splashes.changeStatus'))
@endcomponent
