@component('components.crud.list')
    @slot('title')
        @lang('units')
    @endslot
    @slot('list')
        @lang('units List')
    @endslot
    @slot('add_new')
        @lang('Add unit')
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('units.data'))
    @slot('createRoute', route('units.create'))
    @slot('deleteRoute', route('units.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('units.bulkDelete'))
    @slot('changeStatusMultiRoute', route('units.bulkChangeStatus'))
    @slot('changeStatusRoute', route('units.changeStatus'))
@endcomponent
