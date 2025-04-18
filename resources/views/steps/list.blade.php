@component('components.crud.list')
    @slot('title')
        @lang('steps')
    @endslot
    @slot('list')
        @lang('steps List')
    @endslot
    @slot('add_new')
        @lang('Add step')
    @endslot
    @slot('search_keys')
        @lang('title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('steps.data'))
    @slot('createRoute', route('steps.create'))
    @slot('deleteRoute', route('steps.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('steps.bulkDelete'))
    @slot('changeStatusRoute', route('steps.changeStatus'))
@endcomponent
