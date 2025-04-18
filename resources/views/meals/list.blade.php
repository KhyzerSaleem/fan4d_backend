@component('components.crud.list')
    @slot('title')
        @lang('meals')
    @endslot
    @slot('list')
        @lang('meals List')
    @endslot
    @slot('add_new')
        @lang('Add meal')
    @endslot
    @slot('search_keys')
        @lang('Title')
    @endslot
    @slot('columns', $columns)
    @slot('getDataRoute', route('meals.data'))
    @slot('createRoute', route('meals.create'))
    @slot('deleteRoute', route('meals.destroy', ':modelId'))
    @slot('deleteMultiRoute', route('meals.bulkDelete'))
    @slot('changeStatusMultiRoute', route('meals.bulkChangeStatus'))
    @slot('changeStatusRoute', route('meals.changeStatus'))
@endcomponent
