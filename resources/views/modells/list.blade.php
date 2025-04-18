@component('components.crud.list')
    @slot('title')
        @lang('Modells')
    @endslot
    @slot('list')
        @lang('Modells List')
    @endslot
    @slot('add_new')
        @lang('Add Modell')
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('modells.data'))
    @slot('createRoute', route('modells.create'))
    @slot('deleteRoute', route('modells.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('modells.bulkDelete'))
    @slot('changeStatusRoute', route('modells.changeStatus'))
@endcomponent
